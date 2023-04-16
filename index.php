<?php

/*
Plugin Name: Whatsapp Contact Button
Description: This plugin creates a contact button in the bottom right corner that you can access on Whatsaap without the need to write code.
Version: 0.1
Author: Yilmaz Emre Pala
Author URL: https://www.linkedin.com/in/yilmazemrepala/

*/

add_action("admin_menu", "WhatsappPlugin");

// Icon 
function enable_frontend_dashicons() {
  wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'enable_frontend_dashicons' );

function WhatsappPlugin()
{
    add_menu_page("Whatsapp Plugin", "Whatsapp Contact Button","manage_options", "eklenti_linki","whatsapp_content", "dashicons-whatsapp
");
}

function whatsapp_content()
{
   $postmeta_phone = get_post_meta(14, "whatsapp_phone", true);
   $postmeta_message = get_post_meta(15, "whatsapp_message", true);
    ?>

    <form method="post">
      <h2>Admin Dashboard</h2>
        <label>Your business phone number</label> <br>
        <input type="number" name="phone" value="<?php echo $postmeta_phone; ?>"><br>
        <label> Automated message content</label><br>
        <input style="width: 400px" type="text" name="message" value="<?php echo $postmeta_message; ?>"><br><br>
        <button type="submit">Update</button><br><br>
    </form>

    <?php

    if ($_POST) {
        $phone = $_POST["phone"];
        $message  = $_POST["message"];

        if ($phone != $postmeta_phone) {
            update_post_meta(14, "whatsapp_phone", $phone);
        } elseif ($phone == $postmeta_phone) {
            echo "Phone number is the same. ";
        }

        if ($message != $postmeta_message) {
            update_post_meta(15, "whatsapp_message", $message);
        } elseif ($message == $postmeta_message) {
            echo "Message content is the same.";
        }
    }
}

add_action("wp_head", "whatsapp_button");

function whatsapp_button()
{
    $path = plugin_dir_url(__FILE__);
   $postmeta_phone = get_post_meta(14, "whatsapp_phone", true);
   $postmeta_message = get_post_meta(15, "whatsapp_message", true);


    ?>

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo $path."css/style.css"; ?>">

     <!-- We pull api from Whatsapp and it automatically enters the phone and message. -->
    <a href="https://wa.me/<?php echo $postmeta_phone; ?>/?text=<?php echo $postmeta_message; ?>" target="_blank" class="button">
        <i class="fa fa-whatsapp"></i>
    </a>

    <?php
}
?>