<div class="panel panel-default">
    <div class="panel-heading"><?php echo $atts['title'] ?></div>
    <table class="table">
        <?php while ( $query->have_posts() ) { $query->the_post(); ?>
            <tr>
                <td><?php the_field( 'date' ) ?></td>
                <th><?php the_title() ?></th>
                <td><?php the_field( 'note' ) ?></td>
                <td><a href="<?php the_permalink(); ?>">Detail</a></td>
            </tr>
        <?php } ?>
    </table>
</div>
