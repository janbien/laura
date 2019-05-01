;(function($, w, d, undefined)
{
    $(function()
    { 
        var xhr = null,
            script = $('#script-hooks');

        var menu = $('#wp-admin-bar-wp-inspect');
        
        menu.find('input[id^=wp-inspect-enabled]').on('change', function()
        {            
            var enabled = parseInt($(this).val())
               ,input = menu.find('input').attr('disabled', 'disabled');
           
            xhr && xhr.abort();
            xhr = $.ajax({
                type: 'post',
                url: wpi.ajax_url,
                data: { action: 'ajax', type: 'enable', enabled: 1 === enabled, key: key, id: $(this).data('wpi') },
                success: function(data)
                {
                    input.removeAttr('disabled');                    
                    location.reload();
                }
            });                    
        });        
               
        if (0 === script.length)
            return;
        
        Promise.polyfill();
        
        var getDetail = function(id)
        {                        
            xhr && xhr.abort();
            
            var data = null;
            
            return new Promise(function(resolve, reject)
            {
                if (data = getDetail.cache[id]) {
                    
                    resolve(data);
                    
                } else {

                    xhr && xhr.abort();
                    xhr = $.ajax({
                        type: 'post',
                        url: wpi.ajax_url,
                        data: { action: 'ajax', type: 'detail', key: key, id: id },
                        success: function(data)
                        {
                            getDetail.cache[id] = data;
                            resolve(data);
                        }
                    });
                }
            });            
        };
        
        getDetail.cache = {};        
                
        var hooks = JSON.parse(script.text())        
           ,offcanvas = $('#wpi-offcanvas').addClass('wpi-filter')
           ,ids = [] 
           ,cls = []
           ,html = $('html')
           ,body = $('body');
                                      
        var index = null
           ,url = wpi.plugin_url
           ,key = wpi.request_key
           ,nodes = $('.wpi-action, .wpi-marker').each(function(i)
        {
            var node = $(this)
               ,list = $('<ol>')
               ,skip = false
               ,keys = !node.hasClass('wpi-action')
                     ? node.parent().data('wpi')
                     : node.data('wpi');
                         
            if ('undefined' === typeof keys)
                return;
            
            var hook = null;
            
            $.each(keys, function()
            {
                hook = hooks[this.valueOf()];
                list.append('<li id="wpiref-' + hook.index + '"><a href="#' + hook.tag + '" data-wpi="' + hook.index + '"><pre data-wpi><strong>' + hook.tag + '</strong> | ' + hook.value + '</pre></a></li>');
            });
                        
            if (node.hasClass('wpi-marker'))
                node.attr('title', 'Total ' + keys.length);
               
            var img = $('<img src="' + url + 'assets/images/wpi-white.svg" />')
                ,search = $('<input type="search" data-id="'+ i +'"class="wpi-qtip-search" placeholder="filter the things&hellip;" />')
                ,header = $.merge(img, $('<button>'))
                ,items = list.find('>li')
                ,value = ''
                ,timer;

            node.removeData('wpi-list');
              
            if (node.hasClass('wpi-marker') && items.length >= 5) {
                
                header = $.merge(header, search);
                
                search.on('keyup change', function(e)
                {
                    // TODO(cs) Change to _.debounce;
                    setTimeout(timer);
                    timer = setTimeout(function()
                    {                                    
                        value = $.trim(search.val());

                        if (value.length <= 2) {
                            items.css('display', '');                    
                            return;
                        }

                        items.css('display', 'none');             

                        $.each(index.search(value), function()
                        {
                            items.filter('#wpiref-' + this.ref).css('display', '');
                        });

                    }, 100);                
                });
            }
            
            node.qtip({
                content: {
                    title: ' '                    
                }
               ,hide: {
                    delay: 1500
                   ,fixed: true
                   ,event: 'mouseleave'
                }
               ,show: {
                    delay: 100
                   ,effect: false
                   ,solo: true
               }
               ,position: {
                    my: 'center right'
                   ,at: 'center left'
                   ,viewport: $(window)
                   ,adjust: {
                       mouse: true
                      ,resize: true
                      ,method: 'flip flip'
                  }
                }
                ,style: {
                    classes: 'qtip-parent qtip-light qtip-shadow'
                   ,widget: false
                   ,tip: {
                        corner: true
                        ,mimic: false
                        ,width: 10
                        ,height: 10
                        ,border: 0
                        ,offset: 0
                    }                
                }
               ,events: {
                    hide: function(e, api)
                    {                        
                        var container = api.elements.titlebar.parent()
                           ,content = api.elements.content;
                           
                        if (!node.hasClass('wpi-marker'))
                            return;
                           
                        container.removeClass('qtip-detail qtip-ajax');    
                        content.find('>:not(ol)').remove();
                    },
                    render: function(e, api)                   
                    {
                        var container = api.elements.titlebar.parent() 
                           ,titlebar = api.elements.titlebar
                           ,title = api.elements.title
                           ,content = api.elements.content
                           ,target = api.target;
                           
                        title.append(header);
                        title.find('button').on('click', function(e)
                        {
                            titlebar.parent().removeClass('qtip-detail');
                        });

                        search.on('focus', function()
                        {
                            target.css('width', api.target.outerWidth());

                        }).on('blur', function()
                        {
                            target.css('width', '');
                        });
                        
                        content.empty();
                        
                        if (node.hasClass('wpi-action')) {
                            
                            container.addClass('qtip-detail qtip-ajax qtip-action');
                            content.find('>dl').remove();
                            
                            getDetail(items.first().find('>a').data('wpi')).then(function(data)
                            {
                                content.append(data);
                                setTimeout(function()
                                {
                                    titlebar.find('button').remove();
                                }, 150);
                            });
                            
                        } else {
                            
                            content.append(list);                            
                        
                            items.find('>a').on('click', function(e)
                            {
                                container.addClass('qtip-detail qtip-ajax');
                                content.find('>dl').remove();

                                getDetail($(this).data('wpi')).then(function(data)
                                {
                                    container.removeClass('qtip-ajax');
                                    content.append(data);                                    
                                });
                            });
                        }
                    }                  
                }
            });            
        });
        
        $('.qtip').scrollLock('on', '.qtip-content');
        
        $(w).load(function()
        {
            var search = null, 
                timer;
            
            var actions = $('.wpi-action:visible')
               ,filters = $('.wpi-filter:visible');
               
            var reset = function()
            {
                actions.removeClass('wpi-active').css('display', '');
                filters.removeClass('wpi-active').find('> .wpi-marker').css('display', '');                
            };
                        
            index = lunr(function () {
                this.field('tag', { boost: 10 });
                this.field('value');
                this.ref('index');
            }); 
              
            $('#wp-admin-bar-wp-inspect').on('keyup change', 'input[type=search]', function(e)
            {
                if (null == search)
                    search = $(this); 
                
                clearTimeout(timer);
                timer = setTimeout(function()
                {
                    reset();
                    
                    // Tom-foolery.
                    html.addClass('wpi-search');                    
                    actions.css('display', 'none');
                    filters.find('> .wpi-marker').css('display', 'none');                    
                    html.removeClass('wpi-search');
                    
                    var value = $.trim(search.val());
                    
                    if (value.length < 3) {
                        reset();
                        return;
                    }
                    
                    var results = index.search(value);
                    
                    if (0 === results.length) {
                        reset();
                        return;
                    }
                                        
                    $.each(results, function(i)
                    {
                        var action = actions
                            .filter('#wpi-' + this.ref)
                            .addClass('wpi-active')
                            .css('display', '');
                        
                        var filter = filters
                            .filter('.wpi-' + this.ref)
                            .addClass('wpi-active')
                            .find('> .wpi-marker')                            
                            .css('display', '');
                    });
                    
                }, 100);
                
            });

            $.each(hooks, function(i, hook)
            {
                hook.tag += ' ' + hook.tag.split('_').join(' ');
                index.add(hook);  
            });
            
            var target = $('#screen-meta div.hidden');
            $('#screen-meta-links button').on('click', function(e)
            {
                var id = $(this).parent().attr('id').replace('-link', '');                
                target.filter('#' + id).removeClass('hidden');
            });
        });
    });    
    
})(window.jQuery, window, document, undefined);
