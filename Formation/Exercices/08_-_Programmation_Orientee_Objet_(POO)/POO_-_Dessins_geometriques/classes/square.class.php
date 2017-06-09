<?php
require_once( 'rectangle.class.php' );
class Square extends Rectangle {
    public function showInformation() {
        echo '<fieldset>
    <legend>' . get_class( $this ) . '</legend>

    <table>
        <tr>
            <td>Côté</td>
            <td>' . $this->getWidth() . '</td>
        </tr>
        <tr>
            <td>Aire</td>
            <td>' . $this->area() . '</td>
        </tr>
        <tr>
            <td>Périmètre</td>
            <td>' . $this->perimeter() . '</td>
        </tr>
    </table>
</fieldset>';
    }
} 