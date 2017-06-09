<html>
<head>
    <title></title>
</head>
<body>
<h1>IndexAction from ConversationController</h1>

    <?php 
    if(count($this->conversations)){
    $table = '
<table>
    <tr>
        <th>Id</th>
        <th>Date</th>
        <th>Ouverte</th>
        <th>Total Msg</th>
    </tr>';
    foreach ($this->conversations as $conv) {
        $table .= '
    <tr>
        <td>'.$conv['c_id'].'</td>
        <td>'.$conv['c_date'].'</td>
        <td>'.($conv['c_termine']?'Non':'Oui').'</td>
        <td>'.$conv['m_total'].'</td>
    </tr>
        ';
    }
    $table .= '</table>';
    echo $table;
}else{
    echo '<p>Aucune conversation en base de donnée</p>';
}
     ?>
</body>
</html>