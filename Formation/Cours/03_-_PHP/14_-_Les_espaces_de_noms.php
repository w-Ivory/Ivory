<?php
require_once( '14_-_Les_espaces_de_noms\namespaces\foo.php' );
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les espaces de noms (namespaces)</title>

        <!-- // highlight.js : Coloration syntaxique du code -->
        <link rel="stylesheet" type="text/css" href="../../_assets/plugins/highlight/styles/monokai_sublime.css">
        <script type="text/javascript" src="../../_assets/plugins/highlight/highlight.pack.js"></script>
        <script type="text/javascript">
            hljs.initHighlightingOnLoad();
        </script>
        <!-- // -->

        <link rel="stylesheet" type="text/css" href="../../_assets/css/style.css">
    </head>
    <body>
        <h1>Les espaces de noms (namespaces)</h1>
        <!--
        <p><em></em></p>
        <hr />
        <h2></h2>
        <h3></h3>
        <p><em></em></p>
        <pre><code class="php"></code></pre>
        -->
        <?php
        define( 'MACONST', 'Rrrrrrr' );

        $maVar = 12;
        function maFonction() {
            echo 'World';
        }

        echo MACONST;
        echo \Foo\MACONST;

        \Foo\bar\fopen();
        ?>
    </body>
</html>