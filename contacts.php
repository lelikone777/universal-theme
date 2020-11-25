<?php
/*
Template Name: Страница контактов
Template Post Type: page
*/

get_header();
?>
<section class="section-dark">
    <div class="container">
        <!-- <?php the_title( '<h1 class="page-title">', '</h1>', true); ?> -->
        <h1 class="page-title">Свяжитесь с нами</h1>
        <div class="contacts-wrapper">
            <div class="left">
                <p class="page-text">Через форму обратной связи</p> 

                 <!-- <form action="#" class="contacts-form">
                    <input name="contact_name" type="text" class="input contacts-input" placeholder="Ваше имя">
                    <input name="contact_email" type="email" class="input contacts-input" placeholder="Ваш email">
                    <textarea name="contact_comment" id="" class="textarea contacts-textarea" placeholder="Ваш вопрос"></textarea>
                    <button type="submit" class="button contacts-button">Отправить</button>  -->
                     <?php echo do_shortcode( '[contact-form-7 id="213" title="Контактная форма"]' );  ?> 
                </form> 
               
                <?php the_content();  ?>
            </div>


        </div>
    </div>
</section>
<?php 
get_footer();