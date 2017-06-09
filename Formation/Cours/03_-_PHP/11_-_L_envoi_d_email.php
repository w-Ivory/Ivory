<?php
/**
 * On définit le caractère de saut de ligne en fonction du noyau de système (Pour rappel : le saut de ligne est différent entre les systèmes Windows et UNIX.).
 * La constante PHP_EOL n'existant que depuis PHP5, il faut donc tester avant tout si elle est définie et la définir si ce n'est pas le cas.
**/
if( !defined( 'PHP_EOL') ) { // Si la constante PHP_EOL n'existe pas (http://php.net/manual/fr/reserved.constants.php), 
    if( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) { // Si la version du système d'exploitation (fournie par la constantes pré-définie PHP_OS) correspond à un noyau Windows,
        define( 'PHP_EOL', "\r\n" ); // On définit la constante avec les caractères Windows.
    } else { // Sinon,
        define( 'PHP_EOL', "\n" ); // On définit la constante avec les caractères UNIX.
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>L'envoi d'email</title>

        <!-- // highlight.js : Coloration syntaxique du code -->
        <link rel="stylesheet" type="text/css" href="../../_assets/plugins/highlight/styles/monokai_sublime.css">
        <script type="text/javascript" src="../../_assets/plugins/highlight/highlight.pack.js"></script>
        <script type="text/javascript">
            hljs.initHighlightingOnLoad();
        </script>
        <!-- // -->

        <link rel="stylesheet" type="text/css" href="../../_assets/css/style.css">

        <style type="text/css">
            <!--
            /* --------------------------- */
            /* ------    BALISES    ------ */
            /* --------------------------- */
            /* ------    html5    ------ */
            input[type="color"],input[type="date"],input[type="datetime"],input[type="datetime-local"],input[type="email"],input[type="month"],input[type="number"],input[type="range"],input[type="search"],input[type="tel"],input[type="time"],input[type="url"],input[type="week"],input::-webkit-input-placeholder { -webkit-appearance:none; }
            input[type="search"]::-webkit-search-cancel-button,input[type="search"]::-webkit-search-decoration,input[type="search"]::-webkit-search-results-button,input[type="search"]::-webkit-search-results-decoration { -webkit-appearance:none; }
            /* --------------------------- */
            /* ------    COMPONENTS    ------ */
            /* --------------------------- */
            /* ------    formulaire    ------ */
            [data-role="formulaire"] {
                margin:0;
                padding:0;
                position:relative;
                text-align:left;
            }
            [data-role="formulaire"] [data-role="wrapper"] {
                display:inline-block;
                margin:0 0 7px 0;margin:0 0 .7rem 0;
                overflow:visible;
                padding:0;
                position:relative;
                vertical-align:top;
                width:100%;
            }
            [data-role="formulaire"] [data-role="wrapper"].moitie {
                margin-left:.5%;
                margin-right:.5%;
                width:49.5%;
            }
            [data-role="formulaire"] [data-role="wrapper"].moitie:nth-child(2n+1) { margin-left:0; }
            [data-role="formulaire"] [data-role="wrapper"].moitie:nth-child(2n) { margin-right:0; }
                [data-role="formulaire"] [data-role="label"] {
                    background-color:rgb(255,255,255);
                    bottom:0;
                    color:rgb(21,21,21);
                    display:block;
                    font-style:italic;
                    left:0;
                    padding:4px 7px;padding:.4rem .7rem;
                    position:absolute;
                    right:0;
                    top:0;
                }
                [data-role="formulaire"] [data-role="label"].required::after {
                    content:'*';
                    padding:0 0 0 4px;padding:0 0 0 .4rem;
                }
                [data-role="formulaire"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]),[data-role="formulaire"] textarea,[data-role="formulaire"] select {
                    background-color:rgba(255,255,255,.3);
                    border:rgba(21,21,21,.3) thin solid;
                    display:block;
                    line-height:normal;
                    padding:4px 7px;padding:.4rem .7rem;
                    position:relative;
                    vertical-align:middle;
                    width:100%;

                    /* transition */
                    -webkit-transition-duration:.2s;
                    -moz-transition-duration:.2s;
                    -ms-transition-duration:.2s;
                    -o-transition-duration:.2s;
                    transition-duration:.2s;
                    -webkit-transition-timing-function:ease-in-out;
                    -moz-transition-timing-function:ease-in-out;
                    -ms-transition-timing-function:ease-in-out;
                    -o-transition-timing-function:ease-in-out;
                    transition-timing-function:ease-in-out;
                }
                [data-role="formulaire"] textarea { resize:none; }
                [data-role="formulaire"] input[type="file"] {
                    border:none;
                    display:block;
                    line-height:normal;
                    position:relative;
                    vertical-align:middle;
                    width:100%;
                }
                [data-role="formulaire"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]):focus,[data-role="formulaire"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]):active,[data-role="formulaire"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]).selected,[data-role="formulaire"] textarea:focus,[data-role="formulaire"] textarea:active,[data-role="formulaire"] textarea.selected,[data-role="formulaire"] select:focus,[data-role="formulaire"] select:active,[data-role="formulaire"] select.selected { background-color:rgb(255,255,255); }
                
                [data-role="formulaire"] [data-role="submit"] {
                    background-color:rgb(0,138,166);
                    border:none;
                    color:rgb(255,255,255);
                    cursor:pointer;
                    display:inline-block;
                    font-weight:700;
                    margin:5px 0;margin:.5rem 0;
                    padding:4px 7px;padding:.4rem .7rem;
                    position:relative;
                    text-align:center;
                    text-decoration:none;
                    
                    /* sélection */
                    -webkit-user-select:none;
                    -moz-user-select:none;
                    -ms-user-select:none;
                    -o-user-select:none;
                    user-select:none;
                    /* transition */
                    -webkit-transition-duration:.2s;
                    -moz-transition-duration:.2s;
                    -ms-transition-duration:.2s;
                    -o-transition-duration:.2s;
                    transition-duration:.2s;
                    -webkit-transition-timing-function:ease-in-out;
                    -moz-transition-timing-function:ease-in-out;
                    -ms-transition-timing-function:ease-in-out;
                    -o-transition-timing-function:ease-in-out;
                    transition-timing-function:ease-in-out;
                }
                [data-role="formulaire"] [data-role="submit"]:hover,[data-role="formulaire"] [data-role="submit"]:focus,[data-role="formulaire"] [data-role="submit"]:active { background-color:rgb(62,194,226); }

                [data-role="formulaire"] .text-quote {}
            -->
        </style>
    </head>
    <body>
        <h1>L'envoi d'email</h1>
        <p><em>PHP permet d'envoyer des emails depuis un serveur si les services sont installés et actifs. À l'instar des codes que l'on retrouve dans les logiciels de messagerie, l'envoi d'email par script permet différentes options comme le choix de la méthode d'envoi, les listes de publipostage, l'ajout de pièces jointes, ...</em></p>
        <hr />
        <h2 id="txt">Au format texte brut</h2>
        <p><em>L'envoi d'email en texte brut est le format le plus compatible du fait de la simplicité de son encodage et de son interprétation. De ce fait, il est aussi le format qui maximisera les chancesde ne pas être reconnu en tant que spam car il n'autorise l'exécution d'aucune commande de script.</em></p>
        <?php
        if( isset( $_POST ) && !empty( $_POST ) && array_key_exists( 'submitFrmTxt', $_POST ) ) :
            $_err = array();
            if( ( isset( $_POST['1'] ) && $_POST['1']=='' ) || ( isset( $_POST['2'] ) && $_POST['2']=='Ne pas remplir' ) ) :
                if( isset( $_POST['destinataire'] ) && $_POST['destinataire']!='' ) :
                    if( isset( $_POST['objet'] ) && $_POST['objet']!='' ) :
                        $headers = 'From: noreply@localhost' . PHP_EOL;
                        $headers .= 'MIME-Version: 1.0' . PHP_EOL;
                        $headers .= 'Priority: normal' . PHP_EOL;
                        $headers .= 'Reply-To: contact@localhost' . PHP_EOL;
                        $headers .= 'X-Confirm-Reading-To: contact@localhost' . PHP_EOL;
                        $headers .= 'X-Mailer: PHP/' . phpversion() . PHP_EOL;
                        $headers .= 'X-Priority: 3' . PHP_EOL;
                        if( isset( $_POST['cc'] ) && $_POST['cc']!='' ) :
                            $headers .= 'Cc: ' . $_POST['cc'] . PHP_EOL;
                        endif;
                        if( isset( $_POST['cci'] ) && $_POST['cci']!='' ) :
                            $headers .= 'Bcc: ' . $_POST['cci'] . PHP_EOL;
                        endif;

                        $headers .= 'Content-Type: text/plain; charset=utf-8' . PHP_EOL;
                        $headers .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL;

                        if( mail( $_POST['destinataire'], htmlentities( $_POST['objet'] ), chunk_split( htmlentities( $_POST['message'] ), 70, PHP_EOL ), $headers ) ) :
                            $_err = array( 'code'=>'done', 'msg'=>array( '<span class="titre-action">Message envoyé !</span><br />L\'envoi de votre message s\'est déroulé correctement.<br />Merci pour votre intérêt.' ) );
                        else :
                            $_err['code'] = 'error';
                            $_err['msg'][] = '<span class="titre-action">Échec de l\'envoi !</span><br />Veuillez nous excuser pour ce désagrément.';
                        endif;
                    else :
                        $_err['code'] = 'incomplete';
                        $_err['msg'][] = '<span class="titre-action">Envoi interrompu !</span><br />Veuillez préciser l\'objet du message.';
                    endif;
                else :
                    $_err['code'] = 'incomplete';
                    $_err['msg'][] = '<span class="titre-action">Envoi interrompu !</span><br />Veuillez préciser le(la) destinataire du message.';
                endif;
            else :
                $_err = array( 'code'=>'spam', 'msg'=>array( '<span class="titre-action">Envoi interrompu !</span><br />Vous avez été identifié en tant que spam ! Votre message n\'a donc pas été envoyé.<br />Nous vous présentons nos excuses si votre message ne devait pas être considéré comme tel.' ) ); // On renseigne le code et le message de retour.
            endif;

            if( isset( $_err ) && array_key_exists( 'code', $_err ) ) :
                if( array_key_exists( 'msg', $_err ) ) :
                    foreach( $_err['msg'] as $value ) :
                        echo $value;
                    endforeach;
                endif;
            endif;
        endif;
        ?>
        <form action="#txt" data-role="formulaire" method="post" name="frmContactTxt">
            <span data-role="wrapper">
                <label class="required" for="txt-destFrmTxt">Destinataire</label>
                <input id="txt-destFrmTxt" name="destinataire" required="required" type="email" value="<?php if( isset( $_POST['destinataire'] ) && array_key_exists( 'submitFrmTxt', $_POST ) ) { echo htmlentities( $_POST['destinataire'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label for="txt-ccFrmTxt">Destinataires en copie (séparés par des virgules en respectant le formatage de la norme RFC 2822)</label>
                <input id="txt-ccFrmTxt" name="cc" type="text" value="<?php if( isset( $_POST['cc'] ) && array_key_exists( 'submitFrmTxt', $_POST ) ) { echo htmlentities( $_POST['cc'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label for="txt-cciFrmTxt">Destinataires en copie cachée invisible (séparés par des virgules en respectant le formatage de la norme RFC 2822)</label>
                <input id="txt-cciFrmTxt" name="cci" type="text" value="<?php if( isset( $_POST['cci'] ) && array_key_exists( 'submitFrmTxt', $_POST ) ) { echo htmlentities( $_POST['cci'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label class="required" for="txt-objetFrmTxt">Objet (max. 50 caractères)</label>
                <input id="txt-objetFrmTxt" maxlength="50" name="objet" required="required" type="text" value="<?php if( isset( $_POST['objet'] ) && array_key_exists( 'submitFrmTxt', $_POST ) ) { echo htmlentities( $_POST['objet'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label for="txt-msgFrmTxt">Corps du message</label>
                <textarea id="txt-msgFrmTxt" name="message" rows="20"><?php if( isset( $_POST['message'] ) && array_key_exists( 'submitFrmTxt', $_POST ) ) { echo htmlentities( $_POST['message'] ); } ?></textarea>
            </span>
            <br />
            <span class="text-quote">(*) Champs requis</span>
            
            <br /><input data-role="submit" name="submitFrmTxt" type="submit" value="Envoyer le message" />
            <input name="1" type="hidden" value="" /><input name="2" style="display:none;" type="text" value="Ne pas remplir" />
        </form>
        <pre><code class="css">
/* --------------------------- */
/* ------    BALISES    ------ */
/* --------------------------- */
/* ------    html5    ------ */
input[type="color"],input[type="date"],input[type="datetime"],input[type="datetime-local"],input[type="email"],input[type="month"],input[type="number"],input[type="range"],input[type="search"],input[type="tel"],input[type="time"],input[type="url"],input[type="week"],input::-webkit-input-placeholder { -webkit-appearance:none; }
input[type="search"]::-webkit-search-cancel-button,input[type="search"]::-webkit-search-decoration,input[type="search"]::-webkit-search-results-button,input[type="search"]::-webkit-search-results-decoration { -webkit-appearance:none; }
/* --------------------------- */
/* ------    COMPONENTS    ------ */
/* --------------------------- */
/* ------    formulaire    ------ */
[data-role="formulaire"] {
    margin:0;
    padding:0;
    position:relative;
    text-align:left;
}
[data-role="formulaire"] [data-role="wrapper"] {
    display:inline-block;
    margin:0 0 7px 0;margin:0 0 .7rem 0;
    overflow:visible;
    padding:0;
    position:relative;
    vertical-align:top;
    width:100%;
}
[data-role="formulaire"] [data-role="wrapper"].moitie {
    margin-left:.5%;
    margin-right:.5%;
    width:49.5%;
}
[data-role="formulaire"] [data-role="wrapper"].moitie:nth-child(2n+1) { margin-left:0; }
[data-role="formulaire"] [data-role="wrapper"].moitie:nth-child(2n) { margin-right:0; }
    [data-role="formulaire"] [data-role="label"] {
        background-color:rgb(255,255,255);
        bottom:0;
        color:rgb(21,21,21);
        display:block;
        font-style:italic;
        left:0;
        padding:4px 7px;padding:.4rem .7rem;
        position:absolute;
        right:0;
        top:0;
    }
    [data-role="formulaire"] [data-role="label"].required::after {
        content:'*';
        padding:0 0 0 4px;padding:0 0 0 .4rem;
    }
    [data-role="formulaire"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]),[data-role="formulaire"] textarea,[data-role="formulaire"] select {
        background-color:rgba(255,255,255,.3);
        border:rgba(21,21,21,.3) thin solid;
        display:block;
        line-height:normal;
        padding:4px 7px;padding:.4rem .7rem;
        position:relative;
        vertical-align:middle;
        width:100%;

        /* transition */
        -webkit-transition-duration:.2s;
        -moz-transition-duration:.2s;
        -ms-transition-duration:.2s;
        -o-transition-duration:.2s;
        transition-duration:.2s;
        -webkit-transition-timing-function:ease-in-out;
        -moz-transition-timing-function:ease-in-out;
        -ms-transition-timing-function:ease-in-out;
        -o-transition-timing-function:ease-in-out;
        transition-timing-function:ease-in-out;
    }
    [data-role="formulaire"] textarea { resize:none; }
    [data-role="formulaire"] input[type="file"] {
        border:none;
        display:block;
        line-height:normal;
        position:relative;
        vertical-align:middle;
        width:100%;
    }
    [data-role="formulaire"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]):focus,[data-role="formulaire"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]):active,[data-role="formulaire"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]).selected,[data-role="formulaire"] textarea:focus,[data-role="formulaire"] textarea:active,[data-role="formulaire"] textarea.selected,[data-role="formulaire"] select:focus,[data-role="formulaire"] select:active,[data-role="formulaire"] select.selected { background-color:rgb(255,255,255,1); }
    
    [data-role="formulaire"] [data-role="submit"] {
        background-color:rgb(0,138,166);
        border:none;
        color:rgb(255,255,255);
        cursor:pointer;
        display:inline-block;
        font-weight:700;
        margin:5px 0;margin:.5rem 0;
        padding:4px 7px;padding:.4rem .7rem;
        position:relative;
        text-align:center;
        text-decoration:none;
        
        /* sélection */
        -webkit-user-select:none;
        -moz-user-select:none;
        -ms-user-select:none;
        -o-user-select:none;
        user-select:none;
        /* transition */
        -webkit-transition-duration:.2s;
        -moz-transition-duration:.2s;
        -ms-transition-duration:.2s;
        -o-transition-duration:.2s;
        transition-duration:.2s;
        -webkit-transition-timing-function:ease-in-out;
        -moz-transition-timing-function:ease-in-out;
        -ms-transition-timing-function:ease-in-out;
        -o-transition-timing-function:ease-in-out;
        transition-timing-function:ease-in-out;
    }
    [data-role="formulaire"] [data-role="submit"]:hover,[data-role="formulaire"] [data-role="submit"]:focus,[data-role="formulaire"] [data-role="submit"]:active { background-color:rgb(62,194,226); }

    [data-role="formulaire"] .text-quote {}
</code>
<code class="html">
&lt;form action="" data-role="formulaire" method="post" name="frmContactTxt"&gt;
    &lt;span data-role="wrapper"&gt;
        &lt;label class="required" data-role="label" for="txt-destFrmTxt"&gt;Destinataire&lt;/label&gt;
        &lt;input id="txt-destFrmTxt" name="destinataire" required="required" type="email" value="&lt;?php if( isset( $_POST['destinataire'] ) && array_key_exists( 'submitFrmTxt', $_POST ) ) { echo htmlentities( $_POST['destinataire'] ); } ?&gt;" /&gt;
    &lt;/span&gt;
    &lt;span data-role="wrapper"&gt;
        &lt;label data-role="label" for="txt-ccFrmTxt"&gt;Destinataires en copie (séparés par des virgules en respectant le formatage de la norme RFC 2822)&lt;/label&gt;
        &lt;input id="txt-ccFrmTxt" name="cc" type="text" value="&lt;?php if( isset( $_POST['cc'] ) && array_key_exists( 'submitFrmTxt', $_POST ) ) { echo htmlentities( $_POST['cc'] ); } ?&gt;" /&gt;
    &lt;/span&gt;
    &lt;span data-role="wrapper"&gt;
        &lt;label data-role="label" for="txt-cciFrmTxt"&gt;Destinataires en copie cachée invisible (séparés par des virgules en respectant le formatage de la norme RFC 2822)&lt;/label&gt;
        &lt;input id="txt-cciFrmTxt" name="cci" type="text" value="&lt;?php if( isset( $_POST['cci'] ) && array_key_exists( 'submitFrmTxt', $_POST ) ) { echo htmlentities( $_POST['cci'] ); } ?&gt;" /&gt;
    &lt;/span&gt;
    &lt;span data-role="wrapper"&gt;
        &lt;label class="required" data-role="label" for="txt-objetFrmTxt"&gt;Objet (max. 50 caractères)&lt;/label&gt;
        &lt;input id="txt-objetFrmTxt" maxlength="50" name="objet" required="required" type="text" value="&lt;?php if( isset( $_POST['objet'] ) && array_key_exists( 'submitFrmTxt', $_POST ) ) { echo htmlentities( $_POST['objet'] ); } ?&gt;" /&gt;
    &lt;/span&gt;
    &lt;span data-role="wrapper"&gt;
        &lt;label data-role="label" for="txt-msgFrmTxt"&gt;Corps du message&lt;/label&gt;
        &lt;textarea id="txt-msgFrmTxt" name="message" rows="20"&gt;&lt;?php if( isset( $_POST['message'] ) && array_key_exists( 'submitFrmTxt', $_POST ) ) { echo htmlentities( $_POST['message'] ); } ?&gt;&lt;/textarea&gt;
    &lt;/span&gt;
    &lt;br /&gt;
    &lt;span class="text-quote"&gt;(*) Champs requis&lt;/span&gt;
    
    &lt;br /&gt;&lt;input data-role="submit" name="submitFrmTxt" type="submit" value="Envoyer le message" /&gt;
    &lt;!--
    /**
     * On place des champs afin de mettre en avant une utilisation humaine du formulaire.
     * La plupart du temps, les "robots" se contentent de remplir tous les champs qu'ils lisent dans le code.
     * Étant cachés ces derniers ne peuvent pas être modifiés intentionnellement par un utilisateur donc si leur valeur change, cela signifie que l'envoi est frauduleux.
     * Bien entendu, cela ne bloque malheureusement pas tous les scripts automatisés.
    **/
    --&gt;
    &lt;input name="1" type="hidden" value="" /&gt;&lt;input name="2" style="display:none;" type="text" value="Ne pas remplir" /&gt;
&lt;/form&gt;
</code>
<code class="php">
&lt;?php
if( isset( $_POST ) && !empty( $_POST ) && array_key_exists( 'submitFrmTxt', $_POST ) ) : // S'il y a soumission de formulaire et que des données sont passées,
    $_err = array(); // On définit et initialise une variable que nous utiliserons pour la gestion d'erreur.
    if( ( isset( $_POST['1'] ) && $_POST['1']=='' ) || ( isset( $_POST['2'] ) && $_POST['2']=='Ne pas remplir' ) ) : // Si les valeurs des champs "antispam" sont les mêmes que les valeurs initiales,
        if( isset( $_POST['destinataire'] ) && $_POST['destinataire']!='' ) : // Si un destinataire est renseigné,
            if( isset( $_POST['objet'] ) && $_POST['objet']!='' ) : // Si un objet est renseigné,
                /**
                 * On crée l'en-tête du message qui apporte les diverses informations complémentaires.
                **/
                $headers = 'From: noreply@localhost' . PHP_EOL; // On spécifie l'adresse mail de l'expéditeur. /!\ Cette en-tête est la seule qui soit obligatoire. Si le serveur est configuré correctement, une adresse sera renseignée par défaut si l'instruction n'existe pas dans le script. Si aucune instruction "From" n'est décrite dans le script ou dans la configuration, le serveur retournera une erreur.
                $headers .= 'MIME-Version: 1.0' . PHP_EOL; // On spécifie qu'on utilise le format MIME et sa version.
                $headers .= 'Priority: normal' . PHP_EOL; // On spécifie la priorité du mail (normal | urgent | non-urgent).
                $headers .= 'Reply-To: contact@localhost' . PHP_EOL; // On spécifie une adresse autre que celle de l'expéditeur pour que le destinataire renvoie sa réponse à celle-là et pas celle du "From".
                $headers .= 'X-Confirm-Reading-To: contact@localhost' . PHP_EOL; // On spécifie un mail de retour pour indiquer si le message a été reçu ou lu. Les clients de messagerie demandent habituellement si l'accusé peut être envoyé.
                $headers .= 'X-Mailer: PHP/' . phpversion() . PHP_EOL; // On spécifie le logiciel d'envoi du mail en spécifiant qu'il s'agit d'un script PHP et en précisant sa version (http://php.net/manual/fr/function.phpversion.php).
                $headers .= 'X-Priority: 3' . PHP_EOL; // On spécifie la priorité du mail (entre 1=plus haute et 5=plus basse).
                if( isset( $_POST['cc'] ) && $_POST['cc']!='' ) :
                    $headers .= 'Cc: ' . $_POST['cc'] . PHP_EOL; // Pour "Carbon copy" : sert à lister les destinataires en copie. Chaque destinataire saura qui se trouve sur cette liste.
                endif;
                if( isset( $_POST['cci'] ) && $_POST['cci']!='' ) :
                    $headers .= 'Bcc: ' . $_POST['cci'] . PHP_EOL; // Pour "Blind carbon copy" : sert à lister les destinataires en copie. Chaque destinataire ne saura pas qui se trouve sur cette liste.
                endif;

                $headers .= 'Content-Type: text/plain; charset=utf-8' . PHP_EOL; // On définit le type du contenu du message (text/plain | text/html | multipart | multipart/mixed | multipart/alternative | multipart/digest | image(image/jpeg, image/gif, image/png, ...) | audio(audio/ac3, audio/mp4, ...) | video(video/mpeg, ...) | application | application/octet-stream | application/postscript). Généralement composé d'un type/sous-type. Le type par défaut est "Content-type: text/plain; charset=us-ascii".
                $headers .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL; // On spécifie le type d'encodage (7bit | 8bit | binary | quoted-printable | base64 | ietf-token | x-token).

                if( mail( $_POST['destinataire'], htmlentities( $_POST['objet'] ), chunk_split( htmlentities( $_POST['message'] ), 70, PHP_EOL ), $headers ) ) : // Si le serveur parvient à envoyer l'email (http://php.net/manual/fr/function.mail.php) après avoir épuré les champs (http://php.net/manual/fr/function.htmlentities.php) et scindé le texte (http://php.net/manual/fr/function.chunk-split.php),
                    $_err = array( 'code'=&gt;'done', 'msg'=&gt;array( '&lt;span class="titre-action"&gt;Message envoyé !&lt;/span&gt;&lt;br /&gt;L\'envoi de votre message s\'est déroulé correctement.&lt;br /&gt;Merci pour votre intérêt.' ) ); // On renseigne le code et le message de retour.
                else : // Sinon,
                    $_err['code'] = 'error'; // On renseigne le code de retour.
                    $_err['msg'][] = '&lt;span class="titre-action"&gt;Échec de l\'envoi !&lt;/span&gt;&lt;br /&gt;Veuillez nous excuser pour ce désagrément.'; // On renseigne le message de retour.
                endif;
            else : // Sinon,
                $_err['code'] = 'incomplete'; // On renseigne le code de retour.
                $_err['msg'][] = '&lt;span class="titre-action"&gt;Envoi interrompu !&lt;/span&gt;&lt;br /&gt;Veuillez préciser l\'objet du message.'; // On renseigne le message de retour.
            endif;
        else : // Sinon,
            $_err['code'] = 'incomplete'; // On renseigne le code de retour.
            $_err['msg'][] = '&lt;span class="titre-action"&gt;Envoi interrompu !&lt;/span&gt;&lt;br /&gt;Veuillez préciser le(la) destinataire du message.'; // On renseigne le message de retour.
        endif;
    else : // Sinon,
        $_err = array( 'code'=&gt;'spam', 'msg'=&gt;array( '&lt;span class="titre-action"&gt;Envoi interrompu !&lt;/span&gt;&lt;br /&gt;Vous avez été identifié en tant que spam ! Votre message n\'a donc pas été envoyé.&lt;br /&gt;Nous vous présentons nos excuses si votre message ne devait pas être considéré comme tel.' ) ); // On renseigne le code et le message de retour.
    endif;

    if( isset( $_err ) && array_key_exists( 'code', $_err ) ) : // Si un retour existe,
        if( array_key_exists( 'msg', $_err ) ) :
            foreach( $_err['msg'] as $value ) : // Pour chaque message,
                echo $value; // On affiche le message de retour.
            endforeach;
        endif;
    endif;
endif;
?&gt;</code></pre>
        <hr />
        <h2 id="html">Au format HTML</h2>
        <p><em>Afin de rendre compatible notre message avec tous les interpréteurs et les différentes configurations des utilisateurs, il est conseillé de proposer un affichage alternatif à la version HTML avec une partie texte brute.</em></p>
        <?php
        if( isset( $_POST ) && !empty( $_POST ) && array_key_exists( 'submitFrmAlt', $_POST ) ) :
            $_err = array();
            if( ( isset( $_POST['1'] ) && $_POST['1']=='' ) || ( isset( $_POST['2'] ) && $_POST['2']=='Ne pas remplir' ) ) :
                if( isset( $_POST['destinataire'] ) && $_POST['destinataire']!='' ) :
                    if( isset( $_POST['objet'] ) && $_POST['objet']!='' ) :
                        $contenuTxt = 'Vous avez reçu un message depuis votre formulaire le ' . date( 'd/m/Y' ) . ' à ' . date( 'H:i:s' ) . PHP_EOL . '------------------------------------------------------------------' . PHP_EOL . PHP_EOL . 'Objet : ' . htmlentities( $_POST['objet'] ) . PHP_EOL . htmlentities( $_POST['message'] );
                        $contenuHtml = '<html><head></head><body><table style="width:100%;"><tr><td colspan="2">Vous avez reçu un message depuis votre formulaire le ' . date( 'd/m/Y' ) . ' à ' . date( 'H:i:s' ) . '<br /><hr /><br /></td></tr><tr><td width="50"><strong>Objet</strong></td><td>' . htmlentities( $_POST['objet'] ) . '<br /></td></tr><tr><td colspan="2">' . nl2br( $_POST['message'] ) . '</td></tr></table></body></html>';
                        
                        $boundary = '-----=' . md5( uniqid( microtime(), TRUE ) );

                        $headers = 'From: noreply@localhost' . PHP_EOL;
                        $headers .= 'MIME-Version: 1.0' . PHP_EOL;
                        $headers .= 'Priority: normal' . PHP_EOL;
                        $headers .= 'Reply-To: contact@localhost' . PHP_EOL;
                        $headers .= 'X-Confirm-Reading-To: contact@localhost' . PHP_EOL;
                        $headers .= 'X-Mailer: PHP/' . phpversion() . PHP_EOL;
                        $headers .= 'X-Priority: 3' . PHP_EOL;
                        if( isset( $_POST['cc'] ) && $_POST['cc']!='' ) :
                            $headers .= 'Cc: ' . $_POST['cc'] . PHP_EOL;
                        endif;
                        if( isset( $_POST['cci'] ) && $_POST['cci']!='' ) :
                            $headers .= 'Bcc: ' . $_POST['cci'] . PHP_EOL;
                        endif;
                        $headers .= "Content-Type: multipart/alternative; boundary=\"$boundary\"" . PHP_EOL;

                        $message = PHP_EOL . '--' . $boundary . PHP_EOL;
                            $message .= 'Content-Type: text/html; charset=utf-8' . PHP_EOL;
                            $message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL;
                            $message .= PHP_EOL . $contenuHtml . PHP_EOL;
                        $message .= PHP_EOL . '--' . $boundary . '--' . PHP_EOL;
                            $message .= 'Content-Type: text/plain; charset=utf-8' . PHP_EOL;
                            $message .= 'Content-Transfer-Encoding: quoted-printable' . PHP_EOL;
                            $message .= PHP_EOL . $contenuTxt . PHP_EOL;
                        $message .= PHP_EOL . '--' . $boundary . '--' . PHP_EOL;
                        $message .= PHP_EOL . '--' . $boundary . '--' . PHP_EOL;

                        if( mail( $_POST['destinataire'], htmlentities( $_POST['objet'] ), $message, $headers ) ) :
                            $_err = array( 'code'=>'done', 'msg'=>array( '<span class="titre-action">Message envoyé !</span><br />L\'envoi de votre message s\'est déroulé correctement.<br />Merci pour votre intérêt.' ) );
                        else :
                            $_err['code'] = 'error';
                            $_err['msg'][] = '<span class="titre-action">Échec de l\'envoi !</span><br />Veuillez nous excuser pour ce désagrément.';
                        endif;
                    else :
                        $_err['code'] = 'incomplete';
                        $_err['msg'][] = '<span class="titre-action">Envoi interrompu !</span><br />Veuillez préciser l\'objet du message.';
                    endif;
                else :
                    $_err['code'] = 'incomplete';
                    $_err['msg'][] = '<span class="titre-action">Envoi interrompu !</span><br />Veuillez préciser le(la) destinataire du message.';
                endif;
            else :
                $_err = array( 'code'=>'spam', 'msg'=>array( '<span class="titre-action">Envoi interrompu !</span><br />Vous avez été identifié en tant que spam ! Votre message n\'a donc pas été envoyé.<br />Nous vous présentons nos excuses si votre message ne devait pas être considéré comme tel.' ) ); // On renseigne le code et le message de retour.
            endif;

            if( isset( $_err ) && array_key_exists( 'code', $_err ) ) :
                if( array_key_exists( 'msg', $_err ) ) :
                    foreach( $_err['msg'] as $value ) :
                        echo $value;
                    endforeach;
                endif;
            endif;
        endif;
        ?>
        <form action="#html" data-role="formulaire" method="post" name="frmContactAlt">
            <span data-role="wrapper">
                <label class="required" for="txt-destFrmAlt">Destinataire</label>
                <input id="txt-destFrmAlt" name="destinataire" required="required" type="email" value="<?php if( isset( $_POST['destinataire'] ) && array_key_exists( 'submitFrmAlt', $_POST ) ) { echo htmlentities( $_POST['destinataire'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label for="txt-ccFrmAlt">Destinataires en copie (séparés par des virgules en respectant le formatage de la norme RFC 2822)</label>
                <input id="txt-ccFrmAlt" name="cc" type="text" value="<?php if( isset( $_POST['cc'] ) && array_key_exists( 'submitFrmAlt', $_POST ) ) { echo htmlentities( $_POST['cc'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label for="txt-cciFrmAlt">Destinataires en copie cachée invisible (séparés par des virgules en respectant le formatage de la norme RFC 2822)</label>
                <input id="txt-cciFrmAlt" name="cci" type="text" value="<?php if( isset( $_POST['cci'] ) && array_key_exists( 'submitFrmAlt', $_POST ) ) { echo htmlentities( $_POST['cci'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label class="required" for="txt-objetFrmAlt">Objet (max. 50 caractères)</label>
                <input id="txt-objetFrmAlt" maxlength="50" name="objet" required="required" type="text" value="<?php if( isset( $_POST['objet'] ) && array_key_exists( 'submitFrmAlt', $_POST ) ) { echo htmlentities( $_POST['objet'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label for="txt-msgFrmAlt">Corps du message</label>
                <textarea id="txt-msgFrmAlt" name="message" rows="20"><?php if( isset( $_POST['message'] ) && array_key_exists( 'submitFrmAlt', $_POST ) ) { echo htmlentities( $_POST['message'] ); } ?></textarea>
            </span>
            <br />
            <span class="text-quote">(*) Champs requis</span>
            
            <br /><input data-role="submit" name="submitFrmAlt" type="submit" value="Envoyer le message" />
            <input name="1" type="hidden" value="" /><input name="2" style="display:none;" type="text" value="Ne pas remplir" />
        </form>
        <pre><code class="php">
&lt;?php
if( isset( $_POST ) && !empty( $_POST ) && array_key_exists( 'submitFrmAlt', $_POST ) ) : // S'il y a soumission de formulaire et que des données sont passées,
    $_err = array(); // On définit et initialise une variable que nous utiliserons pour la gestion d'erreur.
    if( ( isset( $_POST['1'] ) && $_POST['1']=='' ) || ( isset( $_POST['2'] ) && $_POST['2']=='Ne pas remplir' ) ) : // Si les valeurs des champs "antispam" sont les mêmes que les valeurs initiales,
        if( isset( $_POST['destinataire'] ) && $_POST['destinataire']!='' ) : // Si un destinataire est renseigné,
            if( isset( $_POST['objet'] ) && $_POST['objet']!='' ) : // Si un objet est renseigné,
                $contenuTxt = 'Vous avez reçu un message depuis votre formulaire le ' . date( 'd/m/Y' ) . ' à ' . date( 'H:i:s' ) . PHP_EOL . '------------------------------------------------------------------' . PHP_EOL . PHP_EOL . 'Objet : ' . htmlentities( $_POST['objet'] ) . PHP_EOL . htmlentities( $_POST['message'] ); // On compose le texte brut.
                $contenuHtml = '&lt;html&gt;&lt;head&gt;&lt;/head&gt;&lt;body&gt;&lt;table style="width:100%;"&gt;&lt;tr&gt;&lt;td colspan="2"&gt;Vous avez reçu un message depuis votre formulaire le ' . date( 'd/m/Y' ) . ' à ' . date( 'H:i:s' ) . '&lt;br /&gt;&lt;hr /&gt;&lt;br /&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width="50"&gt;&lt;strong&gt;Objet&lt;/strong&gt;&lt;/td&gt;&lt;td&gt;' . htmlentities( $_POST['objet'] ) . '&lt;br /&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td colspan="2"&gt;' . nl2br( $_POST['message'] ) . '&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;&lt;/body&gt;&lt;/html&gt;'; // On compose le format HTML.
                
                $boundary = '-----=' . md5( uniqid( microtime(), TRUE ) ); // On définit un délimiteur unique qui va donc nous permettre de séparer les différentes parties de notre e-mail (le texte brut et le format HTML). Les 2 tirets au début sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 

                /**
                 * On crée l'en-tête du message qui apporte les diverses informations complémentaires.
                **/
                $headers = 'From: noreply@localhost' . PHP_EOL; // On spécifie l'adresse mail de l'expéditeur. /!\ Cette en-tête est la seule qui soit obligatoire. Si le serveur est configuré correctement, une adresse sera renseignée par défaut si l'instruction n'existe pas dans le script. Si aucune instruction "From" n'est décrite dans le script ou dans la configuration, le serveur retournera une erreur.
                $headers .= 'MIME-Version: 1.0' . PHP_EOL; // On spécifie qu'on utilise le format MIME et sa version.
                $headers .= 'Priority: normal' . PHP_EOL; // On spécifie la priorité du mail (normal | urgent | non-urgent).
                $headers .= 'Reply-To: contact@localhost' . PHP_EOL; // On spécifie une adresse autre que celle de l'expéditeur pour que le destinataire renvoie sa réponse à celle-là et pas celle du "From".
                $headers .= 'X-Confirm-Reading-To: contact@localhost' . PHP_EOL; // On spécifie un mail de retour pour indiquer si le message a été reçu ou lu. Les clients de messagerie demandent habituellement si l'accusé peut être envoyé.
                $headers .= 'X-Mailer: PHP/' . phpversion() . PHP_EOL; // On spécifie le logiciel d'envoi du mail en spécifiant qu'il s'agit d'un script PHP et en précisant sa version (http://php.net/manual/fr/function.phpversion.php).
                $headers .= 'X-Priority: 3' . PHP_EOL; // On spécifie la priorité du mail (entre 1=plus haute et 5=plus basse).
                if( isset( $_POST['cc'] ) && $_POST['cc']!='' ) :
                    $headers .= 'Cc: ' . $_POST['cc'] . PHP_EOL; // Pour "Carbon copy" : sert à lister les destinataires en copie. Chaque destinataire saura qui se trouve sur cette liste.
                endif;
                if( isset( $_POST['cci'] ) && $_POST['cci']!='' ) :
                    $headers .= 'Bcc: ' . $_POST['cci'] . PHP_EOL; // Pour "Blind carbon copy" : sert à lister les destinataires en copie. Chaque destinataire ne saura pas qui se trouve sur cette liste.
                endif;
                $headers .= "Content-Type: multipart/alternative; boundary=\"$boundary\"" . PHP_EOL; // On spécifie le type du contenu du message. Ici, "multipart/alternative" permet au programme qui reçoit l'e-mail de choisir d'afficher soit la partie HTML, soit la partie texte. Étant "multipart", le "boundary sert à indiquer ce qui délimitera les différentes parties et il a besoin d'être interprété ; d'où les doubles guillemets.

                /**
                 * On crée le corps du message avec les différentes parties.
                **/
                $message = PHP_EOL . '--' . $boundary . PHP_EOL; // On débute l'encadrement général en utilisant le délimiteur défini. Les 2 tirets ajoutés sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 
                $message .= 'Content-Type: text/html; charset=utf-8' . PHP_EOL; // On spécifie le type du contenu de cette partie du message.
                $message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL; // On spécifie le type d'encodage de cette partie du message.
                $message .= PHP_EOL . $contenuHtml . PHP_EOL; // On ajoute le contenu au format HTML.
                $message .= PHP_EOL . '--' . $boundary . '--' . PHP_EOL; // On débute l'encadrement de la sous-partie en utilisant le délimiteur défini. Les 2 tirets ajoutés sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 
                $message .= 'Content-Type: text/plain; charset=utf-8' . PHP_EOL; // On spécifie le type du contenu de cette partie du message.
                $message .= 'Content-Transfer-Encoding: quoted-printable' . PHP_EOL; // On spécifie le type d'encodage de cette partie du message.
                $message .= PHP_EOL . $contenuTxt . PHP_EOL; // On ajoute le contenu en texte brut.
                $message .= PHP_EOL . '--' . $boundary . '--' . PHP_EOL; // On ferme l'encadrement de la sous-partie en utilisant le délimiteur défini. Les 2 tirets ajoutés sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 
                $message .= PHP_EOL . '--' . $boundary . '--' . PHP_EOL; // On ferme l'encadrement général en utilisant le délimiteur défini. Les 2 tirets ajoutés sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 


                if( mail( $_POST['destinataire'], htmlentities( $_POST['objet'] ), $message, $headers ) ) : // Si le serveur parvient à envoyer l'email (http://php.net/manual/fr/function.mail.php),
                    $_err = array( 'code'=&gt;'done', 'msg'=&gt;array( '&lt;span class="titre-action"&gt;Message envoyé !&lt;/span&gt;&lt;br /&gt;L\'envoi de votre message s\'est déroulé correctement.&lt;br /&gt;Merci pour votre intérêt.' ) ); // On renseigne le code et le message de retour.
                else : // Sinon,
                    $_err['code'] = 'error'; // On renseigne le code de retour.
                    $_err['msg'][] = '&lt;span class="titre-action"&gt;Échec de l\'envoi !&lt;/span&gt;&lt;br /&gt;Veuillez nous excuser pour ce désagrément.'; // On renseigne le message de retour.
                endif;
            else : // Sinon,
                $_err['code'] = 'incomplete'; // On renseigne le code de retour.
                $_err['msg'][] = '&lt;span class="titre-action"&gt;Envoi interrompu !&lt;/span&gt;&lt;br /&gt;Veuillez préciser l\'objet du message.'; // On renseigne le message de retour.
            endif;
        else : // Sinon,
            $_err['code'] = 'incomplete'; // On renseigne le code de retour.
            $_err['msg'][] = '&lt;span class="titre-action"&gt;Envoi interrompu !&lt;/span&gt;&lt;br /&gt;Veuillez préciser le(la) destinataire du message.'; // On renseigne le message de retour.
        endif;
    else : // Sinon,
        $_err = array( 'code'=&gt;'spam', 'msg'=&gt;array( '&lt;span class="titre-action"&gt;Envoi interrompu !&lt;/span&gt;&lt;br /&gt;Vous avez été identifié en tant que spam ! Votre message n\'a donc pas été envoyé.&lt;br /&gt;Nous vous présentons nos excuses si votre message ne devait pas être considéré comme tel.' ) ); // On renseigne le code et le message de retour.
    endif;

    if( isset( $_err ) && array_key_exists( 'code', $_err ) ) : // Si un retour existe,
        if( array_key_exists( 'msg', $_err ) ) :
            foreach( $_err['msg'] as $value ) : // Pour chaque message,
                echo $value; // On affiche le message de retour.
            endforeach;
        endif;
    endif;
endif;
?&gt;</code></pre>
        <hr />
        <h2 id="pj">Avec une pièce jointe</h2>
        <p><em>Puisque nous venons de voir que l'on peut cumuler les types d'encodage dans un email, PHP nous permet aussi de lier des pièces jointes.<br />Pour ce faire, nous allons incorporer 2 nouveaux éléments :</em></p>
        <ul style="font-style:italic;">
            <li><strong>la balise "input" de type "file"</strong> qu permet d'ouvrir un explorateur afin de sélectionner un fichier sur notre disque dur</li>
            <li><strong>la superglobale "$_FILES"</strong> qui nous permet de récupérer les informations d'un fichier lors de la soumission du formulaire</li>
        </ul>
        <?php
        if( isset( $_POST ) && !empty( $_POST ) && array_key_exists( 'submitFrmPJ', $_POST ) ) :
            $_err = array();
            if( ( isset( $_POST['1'] ) && $_POST['1']=='' ) || ( isset( $_POST['2'] ) && $_POST['2']=='Ne pas remplir' ) ) :
                if( isset( $_POST['destinataire'] ) && $_POST['destinataire']!='' ) :
                    if( isset( $_POST['objet'] ) && $_POST['objet']!='' ) :
                        $contenuTxt = 'Vous avez reçu un message depuis votre formulaire le ' . date( 'd/m/Y' ) . ' à ' . date( 'H:i:s' ) . PHP_EOL . '------------------------------------------------------------------' . PHP_EOL . PHP_EOL . 'Objet : ' . htmlentities( $_POST['objet'] ) . PHP_EOL . htmlentities( $_POST['message'] );
                        $contenuHtml = '<html><head></head><body><table style="width:100%;"><tr><td colspan="2">Vous avez reçu un message depuis votre formulaire le ' . date( 'd/m/Y' ) . ' à ' . date( 'H:i:s' ) . '<br /><hr /><br /></td></tr><tr><td width="50"><strong>Objet</strong></td><td>' . htmlentities( $_POST['objet'] ) . '<br /></td></tr><tr><td colspan="2">' . nl2br( $_POST['message'] ) . '</td></tr></table></body></html>';
                        move_uploaded_file( $_FILES['pj']['tmp_name'], 'uploads/' . $_FILES['pj']['name'] );
                        $contenuFic = file_get_contents( 'uploads/' . $_FILES['pj']['name'] );
                        $splitBase64Fic = chunk_split( base64_encode( $contenuFic ), 70, PHP_EOL );
                        unlink( 'uploads/' . $_FILES['pj']['name'] );

                        $boundary = '-----=' . md5( uniqid( microtime(), TRUE ) );
                        $boundary2 = '-----=' . md5( uniqid( microtime(), TRUE ) );

                        $headers = 'From: noreply@localhost' . PHP_EOL;
                        $headers .= 'MIME-Version: 1.0' . PHP_EOL;
                        $headers .= 'Priority: normal' . PHP_EOL;
                        $headers .= 'Reply-To: contact@localhost' . PHP_EOL;
                        $headers .= 'X-Confirm-Reading-To: contact@localhost' . PHP_EOL;
                        $headers .= 'X-Mailer: PHP/' . phpversion() . PHP_EOL;
                        $headers .= 'X-Priority: 3' . PHP_EOL;
                        if( isset( $_POST['cc'] ) && $_POST['cc']!='' ) :
                            $headers .= 'Cc: ' . $_POST['cc'] . PHP_EOL;
                        endif;
                        if( isset( $_POST['cci'] ) && $_POST['cci']!='' ) :
                            $headers .= 'Bcc: ' . $_POST['cci'] . PHP_EOL;
                        endif;
                        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"" . PHP_EOL;

                        $message = PHP_EOL . '--' . $boundary . PHP_EOL;
                        $message .= "Content-Type: multipart/alternative; boundary=\"$boundary2\"" . PHP_EOL;
                            $message .= PHP_EOL . '--' . $boundary2 . PHP_EOL;
                                $message .= 'Content-Type: text/plain; charset=utf-8' . PHP_EOL;
                                $message .= 'Content-Transfer-Encoding: quoted-printable' . PHP_EOL;
                                $message .= PHP_EOL . $contenuTxt . PHP_EOL;
                            $message .= PHP_EOL . '--' . $boundary2 . PHP_EOL;
                                $message .= 'Content-Type: text/html; charset=utf-8' . PHP_EOL;
                                $message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL;
                                $message .= PHP_EOL . $contenuHtml . PHP_EOL;
                            $message .= PHP_EOL . '--' . $boundary2 . '--' . PHP_EOL;
                        $message .= PHP_EOL . '--' . $boundary . PHP_EOL;
                            $message .= 'Content-Type : ' . $_FILES['pj']['type'] . '; name=' . $_FILES['pj']['name'] . PHP_EOL;
                            $message .= 'Content-Transfer-Encoding: base64' . PHP_EOL;
                            $message .= 'Content-Disposition: attachment; filename=' . $_FILES['pj']['name'] . PHP_EOL;
                            $message .= PHP_EOL . $splitBase64Fic . PHP_EOL . PHP_EOL;
                        $message .= PHP_EOL . '--' . $boundary . '--' . PHP_EOL;

                        if( mail( $_POST['destinataire'], htmlentities( $_POST['objet'] ), $message, $headers ) ) :
                            $_err = array( 'code'=>'done', 'msg'=>array( '<span class="titre-action">Message envoyé !</span><br />L\'envoi de votre message s\'est déroulé correctement.<br />Merci pour votre intérêt.' ) );
                        else :
                            $_err['code'] = 'error';
                            $_err['msg'][] = '<span class="titre-action">Échec de l\'envoi !</span><br />Veuillez nous excuser pour ce désagrément.';
                        endif;
                    else :
                        $_err['code'] = 'incomplete';
                        $_err['msg'][] = '<span class="titre-action">Envoi interrompu !</span><br />Veuillez préciser l\'objet du message.';
                    endif;
                else :
                    $_err['code'] = 'incomplete';
                    $_err['msg'][] = '<span class="titre-action">Envoi interrompu !</span><br />Veuillez préciser le(la) destinataire du message.';
                endif;
            else :
                $_err = array( 'code'=>'spam', 'msg'=>array( '<span class="titre-action">Envoi interrompu !</span><br />Vous avez été identifié en tant que spam ! Votre message n\'a donc pas été envoyé.<br />Nous vous présentons nos excuses si votre message ne devait pas être considéré comme tel.' ) ); // On renseigne le code et le message de retour.
            endif;

            if( isset( $_err ) && array_key_exists( 'code', $_err ) ) :
                if( array_key_exists( 'msg', $_err ) ) :
                    foreach( $_err['msg'] as $value ) :
                        echo $value;
                    endforeach;
                endif;
            endif;
        endif;
        ?>
        <form action="#pj" data-role="formulaire" enctype="multipart/form-data" method="post" name="frmContactPJ">
            <span data-role="wrapper">
                <label class="required" for="txt-destFrmPJ">Destinataire</label>
                <input id="txt-destFrmPJ" name="destinataire" required="required" type="email" value="<?php if( isset( $_POST['destinataire'] ) && array_key_exists( 'submitFrmPJ', $_POST ) ) { echo htmlentities( $_POST['destinataire'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label for="txt-ccFrmPJ">Destinataires en copie (séparés par des virgules en respectant le formatage de la norme RFC 2822)</label>
                <input id="txt-ccFrmPJ" name="cc" type="text" value="<?php if( isset( $_POST['cc'] ) && array_key_exists( 'submitFrmPJ', $_POST ) ) { echo htmlentities( $_POST['cc'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label for="txt-cciFrmPJ">Destinataires en copie cachée invisible (séparés par des virgules en respectant le formatage de la norme RFC 2822)</label>
                <input id="txt-cciFrmPJ" name="cci" type="text" value="<?php if( isset( $_POST['cci'] ) && array_key_exists( 'submitFrmPJ', $_POST ) ) { echo htmlentities( $_POST['cci'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label class="required" for="txt-objetFrmPJ">Objet (max. 50 caractères)</label>
                <input id="txt-objetFrmPJ" maxlength="50" name="objet" required="required" type="text" value="<?php if( isset( $_POST['objet'] ) && array_key_exists( 'submitFrmPJ', $_POST ) ) { echo htmlentities( $_POST['objet'] ); } ?>" />
            </span>
            <span data-role="wrapper">
                <label for="txt-msgFrmPJ">Corps du message</label>
                <textarea id="txt-msgFrmPJ" name="message" rows="20"><?php if( isset( $_POST['message'] ) && array_key_exists( 'submitFrmPJ', $_POST ) ) { echo htmlentities( $_POST['message'] ); } ?></textarea>
            </span>
            <span data-role="wrapper">
                <label for="file-objetFrmPJ">Pièce jointe</label>
                <input id="file-objetFrmPJ" name="pj" type="file" />
            </span>
            <br />
            <span class="text-quote">(*) Champs requis</span>
            
            <br /><input data-role="submit" name="submitFrmPJ" type="submit" value="Envoyer le message" />
            <input name="1" type="hidden" value="" /><input name="2" style="display:none;" type="text" value="Ne pas remplir" />
        </form>
        <pre><code class="php">
&lt;?php
if( isset( $_POST ) && !empty( $_POST ) && array_key_exists( 'submitFrmPJ', $_POST ) ) : // S'il y a soumission de formulaire et que des données sont passées,
    $_err = array(); // On définit et initialise une variable que nous utiliserons pour la gestion d'erreur.
    if( ( isset( $_POST['1'] ) && $_POST['1']=='' ) || ( isset( $_POST['2'] ) && $_POST['2']=='Ne pas remplir' ) ) : // Si les valeurs des champs "antispam" sont les mêmes que les valeurs initiales,
        if( isset( $_POST['destinataire'] ) && $_POST['destinataire']!='' ) : // Si un destinataire est renseigné,
            if( isset( $_POST['objet'] ) && $_POST['objet']!='' ) : // Si un objet est renseigné,
                $contenuTxt = 'Vous avez reçu un message depuis votre formulaire le ' . date( 'd/m/Y' ) . ' à ' . date( 'H:i:s' ) . PHP_EOL . '------------------------------------------------------------------' . PHP_EOL . PHP_EOL . 'Objet : ' . htmlentities( $_POST['objet'] ) . PHP_EOL . htmlentities( $_POST['message'] ); // On compose le texte brut.
                $contenuHtml = '&lt;html&gt;&lt;head&gt;&lt;/head&gt;&lt;body&gt;&lt;table style="width:100%;"&gt;&lt;tr&gt;&lt;td colspan="2"&gt;Vous avez reçu un message depuis votre formulaire le ' . date( 'd/m/Y' ) . ' à ' . date( 'H:i:s' ) . '&lt;br /&gt;&lt;hr /&gt;&lt;br /&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width="50"&gt;&lt;strong&gt;Objet&lt;/strong&gt;&lt;/td&gt;&lt;td&gt;' . htmlentities( $_POST['objet'] ) . '&lt;br /&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td colspan="2"&gt;' . nl2br( $_POST['message'] ) . '&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;&lt;/body&gt;&lt;/html&gt;'; // On compose le format HTML.
                /**
                 * On gère la pièce jointe.
                **/
                move_uploaded_file( $_FILES['pj']['tmp_name'], 'uploads/' . $_FILES['pj']['name'] ); // On transfert la pièce jointe depuis le tampon de la superglobale "$_FILES" vers un espace disque physique sur le serveur (http://php.net/manual/fr/function.move-uploaded-file.php).
                $contenuFic = file_get_contents( 'uploads/' . $_FILES['pj']['name'] ); // On lit le contenu du fichier et le stocke.
                $splitBase64Fic = chunk_split( base64_encode( $contenuFic ), 70, PHP_EOL ); // On encode le contenu du fichier (http://php.net/manual/fr/function.base64-encode.php) puis on scinde la chaine de caractère en lignes de 70 caractères (http://php.net/manual/fr/function.chunk-split.php).
                unlink( 'uploads/' . $_FILES['pj']['name'] ); // On supprime le fichier du serveur (http://php.net/manual/fr/function.unlink.php).

                $boundary = '-----=' . md5( uniqid( microtime(), TRUE ) ); // On définit un délimiteur unique qui va donc nous permettre de séparer les différentes parties de notre e-mail (le texte brut et le format HTML). Les 2 tirets au début sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 
                $boundary2 = '-----=' . md5( uniqid( microtime(), TRUE ) ); // On définit un deuxième délimiteur pour les sous-parties.

                /**
                 * On crée l'en-tête du message qui apporte les diverses informations complémentaires.
                **/
                $headers = 'From: noreply@localhost' . PHP_EOL; // On spécifie l'adresse mail de l'expéditeur. /!\ Cette en-tête est la seule qui soit obligatoire. Si le serveur est configuré correctement, une adresse sera renseignée par défaut si l'instruction n'existe pas dans le script. Si aucune instruction "From" n'est décrite dans le script ou dans la configuration, le serveur retournera une erreur.
                $headers .= 'MIME-Version: 1.0' . PHP_EOL; // On spécifie qu'on utilise le format MIME et sa version.
                $headers .= 'Priority: normal' . PHP_EOL; // On spécifie la priorité du mail (normal | urgent | non-urgent).
                $headers .= 'Reply-To: contact@localhost' . PHP_EOL; // On spécifie une adresse autre que celle de l'expéditeur pour que le destinataire renvoie sa réponse à celle-là et pas celle du "From".
                $headers .= 'X-Confirm-Reading-To: contact@localhost' . PHP_EOL; // On spécifie un mail de retour pour indiquer si le message a été reçu ou lu. Les clients de messagerie demandent habituellement si l'accusé peut être envoyé.
                $headers .= 'X-Mailer: PHP/' . phpversion() . PHP_EOL; // On spécifie le logiciel d'envoi du mail en spécifiant qu'il s'agit d'un script PHP et en précisant sa version (http://php.net/manual/fr/function.phpversion.php).
                $headers .= 'X-Priority: 3' . PHP_EOL; // On spécifie la priorité du mail (entre 1=plus haute et 5=plus basse).
                if( isset( $_POST['cc'] ) && $_POST['cc']!='' ) :
                    $headers .= 'Cc: ' . $_POST['cc'] . PHP_EOL; // Pour "Carbon copy" : sert à lister les destinataires en copie. Chaque destinataire saura qui se trouve sur cette liste.
                endif;
                if( isset( $_POST['cci'] ) && $_POST['cci']!='' ) :
                    $headers .= 'Bcc: ' . $_POST['cci'] . PHP_EOL; // Pour "Blind carbon copy" : sert à lister les destinataires en copie. Chaque destinataire ne saura pas qui se trouve sur cette liste.
                endif;
                $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"" . PHP_EOL; // On spécifie le type du contenu du message. Ici, "multipart/mixed" permet au programme qui reçoit l'e-mail d'être prévenu qu'il va recevoir plusieurs parties de plusieurs types différents. Étant "multipart", le "boundary sert à indiquer ce qui délimitera les différentes parties et il a besoin d'être interprété ; d'où les doubles guillemets.

                /**
                 * On crée le corps du message avec les différentes parties.
                **/
                $message = PHP_EOL . '--' . $boundary . PHP_EOL; // On débute l'encadrement général en utilisant le délimiteur défini. Les 2 tirets ajoutés sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 
                $message .= "Content-Type: multipart/alternative; boundary=\"$boundary2\"" . PHP_EOL; // On spécifie le type du contenu de cette partie du message.
                $message .= PHP_EOL . '--' . $boundary2 . PHP_EOL; // On débute l'encadrement de la sous-partie en utilisant le délimiteur défini. Les 2 tirets ajoutés sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 
                $message .= 'Content-Type: text/plain; charset=utf-8' . PHP_EOL; // On spécifie le type du contenu de cette partie du message.
                $message .= 'Content-Transfer-Encoding: quoted-printable' . PHP_EOL; // On spécifie le type d'encodage de cette partie du message.
                $message .= PHP_EOL . $contenuTxt . PHP_EOL; // On ajoute le contenu en texte brut.
                $message .= PHP_EOL . '--' . $boundary2 . PHP_EOL; // On débute l'encadrement de la sous-partie alternative en utilisant le délimiteur défini. Les 2 tirets ajoutés sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 
                $message .= 'Content-Type: text/html; charset=utf-8' . PHP_EOL; // On spécifie le type du contenu de cette partie du message.
                $message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL; // On spécifie le type d'encodage de cette partie du message.
                $message .= PHP_EOL . $contenuHtml . PHP_EOL; // On ajoute le contenu au format HTML.
                $message .= PHP_EOL . '--' . $boundary2 . '--' . PHP_EOL; // On ferme l'encadrement de la sous-partie alternative en utilisant le délimiteur défini. Les 2 tirets ajoutés sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 
                $message .= PHP_EOL . '--' . $boundary . PHP_EOL; // On ferme l'encadrement de la sous-partie en utilisant le délimiteur défini. Les 2 tirets ajoutés sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 
                $message .= 'Content-Type : ' . $_FILES['pj']['type'] . '; name=' . $_FILES['pj']['name'] . PHP_EOL; // On spécifie le type du contenu de cette partie du message.
                $message .= 'Content-Transfer-Encoding: base64' . PHP_EOL; // On spécifie le type d'encodage de cette partie du message.
                $message .= 'Content-Disposition: attachment; filename=' . $_FILES['pj']['name'] . PHP_EOL; // On spécifie l'emplacement de cette partie du message.
                $message .= PHP_EOL . $splitBase64Fic . PHP_EOL . PHP_EOL; // On ajoute le contenu encodé du fichier.
                $message .= PHP_EOL . '--' . $boundary . '--' . PHP_EOL; // On ferme l'encadrement général en utilisant le délimiteur défini. Les 2 tirets ajoutés sont obligatoires pour des raisons de compatibilité avec une ancienne norme qui est la RFC934. 


                if( mail( $_POST['destinataire'], htmlentities( $_POST['objet'] ), $message, $headers ) ) : // Si le serveur parvient à envoyer l'email,
                    $_err = array( 'code'=&gt;'done', 'msg'=&gt;array( '&lt;span class="titre-action"&gt;Message envoyé !&lt;/span&gt;&lt;br /&gt;L\'envoi de votre message s\'est déroulé correctement.&lt;br /&gt;Merci pour votre intérêt.' ) ); // On renseigne le code et le message de retour.
                else : // Sinon,
                    $_err['code'] = 'error'; // On renseigne le code de retour.
                    $_err['msg'][] = '&lt;span class="titre-action"&gt;Échec de l\'envoi !&lt;/span&gt;&lt;br /&gt;Veuillez nous excuser pour ce désagrément.'; // On renseigne le message de retour.
                endif;
            else : // Sinon,
                $_err['code'] = 'incomplete'; // On renseigne le code de retour.
                $_err['msg'][] = '&lt;span class="titre-action"&gt;Envoi interrompu !&lt;/span&gt;&lt;br /&gt;Veuillez préciser l\'objet du message.'; // On renseigne le message de retour.
            endif;
        else : // Sinon,
            $_err['code'] = 'incomplete'; // On renseigne le code de retour.
            $_err['msg'][] = '&lt;span class="titre-action"&gt;Envoi interrompu !&lt;/span&gt;&lt;br /&gt;Veuillez préciser le(la) destinataire du message.'; // On renseigne le message de retour.
        endif;
    else : // Sinon,
        $_err = array( 'code'=&gt;'spam', 'msg'=&gt;array( '&lt;span class="titre-action"&gt;Envoi interrompu !&lt;/span&gt;&lt;br /&gt;Vous avez été identifié en tant que spam ! Votre message n\'a donc pas été envoyé.&lt;br /&gt;Nous vous présentons nos excuses si votre message ne devait pas être considéré comme tel.' ) ); // On renseigne le code et le message de retour.
    endif;

    if( isset( $_err ) && array_key_exists( 'code', $_err ) ) : // Si un retour existe,
        if( array_key_exists( 'msg', $_err ) ) :
            foreach( $_err['msg'] as $value ) : // Pour chaque message,
                echo $value; // On affiche le message de retour.
            endforeach;
        endif;
    endif;
endif;
?&gt;</code></pre>
        <p class="block alert"><em>Si vous prévoyez d'envoyer des mails HTML ou autrement plus complexes, il est recommandé d'utiliser le paquet PEAR » <a href="http://pear.php.net/package/Mail_Mime" target="_blank" title="">PEAR::Mail_Mime</a> ou encore, d'utiliser le package de la classe <a href="https://github.com/PHPMailer/PHPMailer" target="_blank" title="">PHPMailer</a>.</em></p>
    </body>
</html>