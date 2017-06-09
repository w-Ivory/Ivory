<?php
class MyClass {
    private $prop1;
    private $tabProp = [];

    public function setProp1( $val ) {
        $this->prop1 = $val;
    }

    public function getProp1() {
        return $this->prop1;
    }

    final public function AcceptParam($param)
    {
        if($param === NULL)
        {
            return false;
        }
        return $this->AcceptNonNullParam($param);
    }

    protected function AcceptNonNullParam($param)
    {
        //...
    }


    public function __set( $property, $value ) {
        if( in_array( $property, array( 'name', 'firstname', 'property2', 'tmp' ) ) )
            if( is_numeric( $value ) )
                $this->tabProp[$property] = $value;
    }

    public function __get( $property ) {
        return $this->tabProp[$property];
    }

    // public function __set( $property, $value ) {
    //     $this->$property = $value;
    // }

    // public function __get( $property ) {
    //     return $this->$property;
    // }

    public function __isset( $property ) {
        // if( isset( $this->tabProp[$property] ) )
        //     return true;

        // return false;

        return isset( $this->tabProp[$property] );
    }

    public function __unset( $property ) {
        if( isset( $this->tabProp[$property] ) )
            unset( $this->tabProp[$property] );
    }
}

$my_class = new MyClass;
$my_class->property1 = 'Ceci est ma propriété 1';
$my_class->property2 = 0;
$my_class->firstname = 23;

if( isset( $my_class->property1 ) )
    echo 'Propriete magique : ' . $my_class->property1 . '<br>';
if( isset( $my_class->property2 ) )
    echo 'Propriete magique : ' . $my_class->property2 . '<br>';
if( isset( $my_class->name ) )
    echo 'Propriete magique : ' . $my_class->name . '<br>';
if( isset( $my_class->firstname ) )
    echo 'Propriete magique : ' . $my_class->firstname . '<br>';


$my_class->tmp = '560';
echo $my_class->tmp;
unset( $my_class->tmp );
echo $my_class->tmp;