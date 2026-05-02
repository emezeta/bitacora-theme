<?php
/**
 * Bitácora de Obra - Template de comentarios.
 */

if ( post_password_required() ) {
    return;
}

if ( 'bitacora' !== get_post_type() ) {
    return;
}
?>
<section id="comments" class="obras-comments-section">
    <h2 class="obras-comments-title">Comentarios</h2>

    <p class="obras-comments-note">
        Debajo de cada nota hay un espacio para comentarios.
    </p>

    <?php if ( have_comments() ) : ?>
        <ol class="obras-comment-list">
            <?php
            wp_list_comments(
                array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 0,
                    'max_depth'   => 3,
                )
            );
            ?>
        </ol>

        <?php the_comments_navigation(); ?>
    <?php else : ?>
        <p class="obras-comments-empty">Todavía no hay comentarios en esta nota.</p>
    <?php endif; ?>

    <?php if ( comments_open() ) : ?>
        <?php
        comment_form(
            array(
                'title_reply'          => 'Escribí un comentario',
                'label_submit'         => 'Publicar comentario',
                'comment_notes_before' => '',
                'comment_notes_after'  => '',
                'logged_in_as'         => '',
                'class_form'           => 'obras-comment-form',
                'class_submit'         => 'submit obras-comment-submit',
                'comment_field'        => '<p class="comment-form-comment"><label for="comment">Comentario</label><textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required="required" placeholder="Escribí aquí tu comentario"></textarea></p>',
            )
        );
        ?>
    <?php else : ?>
        <p class="obras-comments-closed">Los comentarios están cerrados para esta nota.</p>
    <?php endif; ?>
</section>
