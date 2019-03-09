<div class="header__text-box">
            <span class="heading-primary--main-2">Contacts</span>
        </div>


    </header>

<div class="contact-us">
    <div class="contact-us__section">
        <svg class="contact-us__img">
            <use xlink:href="<?php echo base_url();?>assets/images/sprite.svg#icon-volume-control-phone"></use>
        </svg>
    
        <?php for($i = 1; $i <= 5; $i++) : ?>
            <h4 class="contact-us__text"><?php $contact = 'contact_'.$i; echo $company->$contact ;?></h4>
        <?php endfor; ?>

    </div>
    <div class="contact-us__section">
        <svg class="contact-us__img">
            <use xlink:href="<?php echo base_url();?>assets/images/sprite.svg#icon-home"></use>
        </svg>
        <h1 class="contact-us__text"><?php echo $company->address;?></h1>
    </div>
    <div class="contact-us__section">
        <svg class="contact-us__img">
            <use xlink:href="<?php echo base_url();?>assets/images/sprite.svg#icon-comments-o"></use>
        </svg>
        <h4 class="contact-us__text"><?php echo $company->email;?></h4>
    </div>
</div>
<hr>
<section class="section-mails">
    <div class="section-mail">
        <div class="section-mail__title">send us a Mail</div>
        <?php echo form_open('publicMailController/mail', 'class="section-mail--form"'); ?>
        <label for="name">Your Name</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Your Email</label>
        <input type="email" id="email" name="email" required> 
        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" required>
        <label for="message">Message</label>
        <textarea  type="text" id="message" cols="30" rows="10" name="message" required></textarea>
        <input type="submit" value="Send" class="btn" >
        <?php echo form_close(); ?>
    </div>
    <div class="section-two" style="background-image:url(<?php echo base_url();?>assets/images/bg_2.jpeg)">
        </div>
    </section>

    <hr>
    
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15843.483148130663!2d79.871764!3d6.906051!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x7909870db8510336!2sDisaster+Management+Centre!5e0!3m2!1sen!2slk!4v1550604757582"     width="100%" height="450" frameborder="0" style="border:none; display: block;" allowfullscreen></iframe>
   
   
   <script>
    const urlAnchor = window.location.hash.substr(1);

    if (urlAnchor && (urlAnchor === 'message-success')) 
        alert('We recived your message. We will get back to you shortly!');

    if (urlAnchor && (urlAnchor === 'message-error')) 
        alert('Unable to send your message. Please try again later!');

    if (urlAnchor) {
        window.history.replaceState('', 'Public', '#'); 
    }
    
    </script>