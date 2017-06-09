<?php include('header.php'); ?>
        <p>
        <?php
        if( isset( $_POST ) && array_key_exists( 'txt', $_POST ) ) :
            $maVar = htmlentities( $_POST['txt'] );
            echo ' ' . $maVar;
        endif;
        ?>
        </p>
<?php include('footer.php'); ?>