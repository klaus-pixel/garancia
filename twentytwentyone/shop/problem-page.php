<?php 
/* 
Template Name: Problem Page
*/ 

get_header();
?>

    <div class="filter js-filter">
    <!-- onsubmit="return formValidation()"   -->
                
    </div>
    
    <div class="entry-content">
        <?php the_content('<p>', '<p>'); ?>

            <form  name="contactForm" id="contactform" method="post" action="" data-url="<?php echo admin_url('admin-ajax.php');?>">

                <div class="row">
                    <div class="label">Emri:</div>
                    <input type="text" id="name" name="name" class="field-input" >
                    <snall class="field-msg error" data-error="invalidName">Emri eshte i detyrueshem</snall>
                </div>

                <div class="row">
                    <div class="label">Email:</div>
                    <input type="email" id="email" name="email" class="field-input" >
                    <snall class="field-msg error" data-error="invalidEmail">Emaili eshte i detyrueshem</snall>
                </div>

                <div class="row">
                    <div class="label">Subjekti:</div>
                    <input type="text" id="subject" name="subject" class="field-input" >
                    <snall class="field-msg error" data-error="invalidSubjekt">Subjekti eshte i detyrueshem</snall>
                </div>
                
                <div class="row">
                    <div class="label">NR ID:</div>
                    <input type="number" id="id" name="id" class="field-input" >
                    <snall class="field-msg error" data-error="invalidId">Nr ID eshte i detyrueshem</snall>
                </div>
                
                <div class="filter-cat row-column">
                    <select class="form-control" id="category" name="categoryselect" >
                        <option selected hidden><?php echo ('Produktet'); ?></option>
                        <?php 
                            $categories = get_categories('taxonomy=tipi&post_type=produkte'); 
                            foreach ($categories as $cat) : ?>
                                <option class="js-filter-item" value="<?= $cat->term_id; ?>">
                                    <?= $cat->name; ?>
                                </option>
                            <?php                        
                            endforeach; 
                        ?>
                            <snall class="field-msg error" data-error="invalidProdukt">Ju lutem selektoni produktinin</snall>
                        </select>
                </div>
                <div class="row-column show">
                    <select class="form-control" id="produkte" name="produktselect">

                    </select>
                </div>		
                <div class="row">
                    <div class="label">Mesazhi:</div>
                    <textarea id="message" name="message" rows="3" class="field-input" ></textarea>
                    <snall class="field-msg error" data-error="invalidMessage">Mesazhi eshte i detyrueshem</snall>
                </div>

                <div class="row">
                   <div>
                        <button type="submit" class="btn btn-default btn-lg btn-sunset-form">Dergo</button>
                   </div>
                        <snall class="field-msg js-form-submission">Kerkesa po perpunohet</snall>
                        <snall class="field-msg success js-form-success">Kerkesa u dergua me sukses</snall>
                        <snall class="field-msg error js-form-error">Nodhi nje gabim, Ju lutem provoni me vone</snall>
                </div>

                <input type="hidden" name="action" value="submit_raportimin">
            </form>
        </div>
    <?php
    get_footer();
     ?>