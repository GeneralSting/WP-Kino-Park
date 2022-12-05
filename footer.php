<?php
$footer_logo_path = get_template_directory_uri() . '/assets/images/icon/kinoPark_footerLogo.png';
?>
<footer class="footer text-center py-2 theme-bg-dark" class="footer">
    <div class="column justify-content-md-center">
        <div class="col-md-auto">
            <img src="<?php echo $footer_logo_path ?>" alt="footer logo" class="footer-logo">
            <p class="footer-text">033 721 786 - ul Matije Gupca 5 - 33000 Virovitica</p>
            <p><a class="footer-text" href="">&#169; Kino Park</a></p>
        </div>
    </div>

</footer>
<?php
//Kako bi se pokrenio kod unutar datoteke functions.php potrebno je prije zatvaranja <body>
//elementa pozvati WordPress funkciju wp_footer()
//*wp_head()* 
wp_footer();
?>
<!--zatvaramo otvoreni <body> i <html> u header.php-->
</body>

</html>