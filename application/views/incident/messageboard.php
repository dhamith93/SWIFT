<?php
    $userType = $this->session->userdata('user_type');
    $username = $this->session->userdata('username');

    if ($userType === 'Employee') {
        $userId = $this->employee_model->getEmpId($username);
    } else {
        $userId = $this->responder_model->getResId($username);
    }
?>

<script>
    const currentUserId = parseInt(<?php echo $userId; ?>);
</script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/messageboard.css">
<div class="section">
    <textarea class="textarea" id="msg-content" placeholder="Your message..."></textarea>
    <br>
    <button class="button is-link" id="msg-send-btn">Send</button>

    <hr>

    <div id="msg-box"></div>
</div>

<script src="<?php echo base_url(); ?>assets/scripts/messageboard.js"></script>