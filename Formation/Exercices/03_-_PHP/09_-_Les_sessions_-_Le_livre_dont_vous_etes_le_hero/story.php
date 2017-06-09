﻿<?php
$story = array(
    array(
        'text'      => 'Vous vous réveillez difficilement. Lorsque vos yeux s\'adaptent enfin à la pénombre, vous commencez à observer votre environnement. Vous êtes dans un cachot sans fenêtres, une odeur de moisissure flotte dans l\'air. La pièce comporte uniquement une porte en métal lourd, une petite bougie, qui est la seule source de lumière, le lit sur lequel vous vous êtes réveillé(e), qui est plus comparable à un bloc de pierre, et un seau dont vous préférez ne pas connaitre le contenu. Mais ce qui attire le plus votre attention , c\'est la présence sur les murs et le sol de traces de sang séché, beaucoup trop pour appartenir à une seule personne.
Avant de pouvoir analyser votre cellule plus en détail, vous entendez des bruits de pas se rapprochant et la lumière vacillante d\'une torche de plus en plus visible sous la porte.',
        'choice'    => array(
            array(
                'text'  => 'Attendre',
                'goto'  => 1
            ),
            array(
                'text'  => 'Paniquer',
                'goto'  => 2
            )
        )
    ),
array('text' => 'Souhaitez-vous dancer pendant que vous attendez?',
'choice' => array(
        array('text' => 'Quelle bonne idée!', 'goto' => 3),
        array('text' => 'Non merci', 'goto' => 5)
    )
),
array('text' => 'Vous décidez que la meilleure action à entreprendre dans cette situation est de paniquer. Vous vous mettez à gesticuler, à crier et à courir partout dans votre cellule. Vous commencez même à citer des passages de votre livre favori en allemand, et commencez à penser que vous avez suffisament de voix pour faire carrière dans le heavy metal.',
'choice' => array(
        array('text' => 'Continuer', 'goto' => 3)
    )
),
array('text' => 'Lorsque la porte de votre cellule s\'ouvre, ce qui semble être un garde commence à rentrer. Il porte une armure en cuir, renforcée au niveau du torse(et probablement du dos) par des plaques d\'acier, et un casque simple en acier, probablement plus utile pour se protéger d\'un homme non armé que pour faire la guerre. Cependant, au moment où il tourne son regard vers vous, il marque un long temps d\'hésitation devant votre comportement pour le moins... original. C\'est peut-être la seule occasion que vous aurez.',
'choice' => array(
        array('text' => 'Tenter de fuir', 'goto' => 6),
        array('text' => 'Supplier', 'goto' => 7),
        array('text' => 'Continuer votre manège', 'goto' => 4)
    )
),
array('text' => 'Vous jugez que la présence du garde n\'est pas une réaison suffisante pour changer de comportement. Alors que continuez comme si le garde n\'était pas présent, celui-ci se ressaisit et s\'approche de vous. Il tente de vous calmer, mais vous restez sourd à ses tentatives. Le garde finit par perdre patience et vous frappe violament sur le crâne.',
'choice' => array(
        array('text' => 'Tomber dans les pommes', 'goto' => 0)
    )
),
array('text' => 'Vous restez immobile, écoutant les bruits de pas qui se rapprochent. Vous retenez votre souffle quand vous les entendez passer votre cellule sans ralentir. Quelques instants plus tard, les bruits sont réduis à des échos, et les échos à des murmures, qui finissent par s\'éteindre. Soulagé(e), vous vous rappelez alors que vous retenez encore votre souffle.',
'choice' => array(
        array('text' => 'Reprendre votre souffle', 'goto' => 8)
    )
),
array('text' => 'Profitant de la confusion du garde, vous le bousculez et prenez la fuite à travers les couloirs. Ignorant ses vociférations, vous courez à perdre haleine le long du couloir.',
'choice' => array(
        array('text' => 'Continuer', 'goto' => 13),
        array('text' => 'S\'arrêter', 'goto' => 10)
    )
),
array('text' => 'En larmes, vous vous jetez aux genoux du garde, qui semble réellement pris au dépourvu par votre changement soudain d\'humeur(vous ne seriez pas bipolaire par hasard?). Vous lui expliquez que c\'est un immense erreur judiciaire, que vous n\'avez jamais blessé personne, à part bubulle le poisson rouge, mais que ça ne compte pas, parce que personne ne l\'aimait de toute façon. Le garde, s\'étant rapidement repris, vous projette en arrière d\'un violent coup de pied et claque la porte après vous avoir jeté un regard mauvais.',
'choice' => array(
        array('text' => 'Vous relever', 'goto' => 8)
    )
),
array('text' => 'Vous êtes seul dans votre cellule. Le couloir semble calme.',
'choice' => array(
        array('text' => 'Écouter à la porte', 'goto' => 11),
        array('text' => 'Éteindre la bougie', 'goto' => 9),
        array('text' => 'Chercher un passage secret', 'goto' => 14)
    )
),
array('text' => 'Vous éteignez la seule source de lumière présente, très malin. Vous n\'y voyez plus rien et ne pouvez plus rien faire. Fort heureusement, le narrateur, prenant pitié de vous, vous offre un raccourci scénaristique inexpliquable pour rallumer la bougie et reprendre.',
'choice' => array(
        array('text' => 'Prendre le raccourci scénaristique inexpliquable', 'goto' => 8)
    )
),
array('text' => 'Soudain pris(e) d\'une crise de stupidité aigue, vous vous arrêtez en plein milieu de votre course. Le garde vous rattrappe, et vous ressentez une forte douleur à l\'arrière du crâne. À quoi vous attendiez-vous?',
'choice' => array(
        array('text' => 'Tomber dans les pommes', 'goto' => 0)
    )
),
array('text' => 'Collant votre oreille à la porte, vous tentez de repérer de l\'activité dans le couloir. N\'entendant rien, vous appuyez votre oreille un peu plus fort contre la porte, qui tombe alors dans le couloir. Il semblerait que les gongs n\'aient pas encore été inventés. Le bruit aura sûrement attiré des gardes, cependant.',
'choice' => array(
        array('text' => 'Remettre la porte en place', 'goto' => 12),
        array('text' => 'Prendre la fuite', 'goto' => 13)
    )
),
array('text' => 'Vous replacez la porte dans son cadre et attendez  dans votre cellules. Vous entendez une poingée de personnes passer en courant devant votre cellule.',
'choice' => array(
        array('text' => 'Continuer', 'goto' => 8)
    )
),
array('text' => 'Vous courrez à présent dans un couloir, une troupe de gardes à vos trousses. Heureusement pour vous, le poids de leur équipement les ralentis.
Vous finissez par semer vos poursuivants et arrivez devant une intersection, un couloir partant à gauche et l\'autre à droite. Reprenant votre souffle, vous décidez de la suite.',
'choice' => array(
        array('text' => 'Aller à gauche', 'goto' => 18),
        array('text' => 'Aller à droite', 'goto' => 15),
        array('text' => 'Aller tout droit', 'goto' => 17)
    )
),
array('text' => 'En regardant attentivement, vous remarquez des traces de frottement sur la pierre au pied du lit. Poussant la lourde dalle de pierre, vous découvrez un escalier. Vous décidez de l\'emprunter. En bas de l\'escalier vous arrivez devant un long couloir.',
'choice' => array(
        array('text' => 'Continuer', 'goto' => 15)
    )
),
array('text' => 'Suivant le couloir, vous arrivez bientôt dans une grande pièce circulaire. En atteignant le centre, une... chose surgit soudainement de nulle part. De forme humanoide, légèrement transparente et surtout sans visage, la créature vous fait face. "Cette chose n\'a rien de naturel" vous dit immédiatement le narrateur.',
'choice' => array(
        array('text' => 'Vous battre', 'goto' => 20),
        array('text' => 'Marchander', 'goto' => 21),
        array('text' => 'Fuir', 'goto' => 19),
        array('text' => 'Appeler les frères Winchester', 'goto' => 16)
    )
),
array('text' => 'Bonne idée, mais pour des raison de droit d\'auteur, vous ne pourrez pas obtenir leur aide.
Vous avez perdu trop de temps, vous ne pouvez plus fuir, vous allez devoir faire face à la créature.',
'choice' => array(
        array('text' => 'Vous battre', 'goto' => 20),
        array('text' => 'Marchander', 'goto' => 21)
    )
),
array('text' => 'Vous vous cognez au mur en face de vous. Je répète : "un couloir partant à gauche et l\'autre à droite"',
'choice' => array(
        array('text' => 'Aller à gauche', 'goto' => 18),
        array('text' => 'Aller à droite', 'goto' => 15)
    )
),
array('text' => 'Au bout du couloir, vous apercevez une personne qui semble vous attendre. En vous approchant vous vous apercevez qu\'il s\'agit d\'un de vos ennemis mortels : UN DESIGNER. Pire encore, il est armé : il a des croquis à la main!',
'choice' => array(
        array('text' => 'Regarder ses croquis', 'goto' => 25),
        array('text' => 'Faire un dessin', 'goto' => 24)
    )
),
array('text' => 'N\'écoutant que votre courage, vous décidez de prendre la fuite par la première sortie que vous trouvez.',
'choice' => array(
        array('text' => 'Continuer', 'goto' => 18)
    )
),
array('text' => 'Malgré l\'apparence ethérée de la créature, vous remarquez très vite qu\'elle est bien physique, notamment au moment où votre poing rencontre ce qui est supposément sa machoire.
Cependant, votre effet de surprise ne suffit pas à vous faire prendre l\'avantage, et la créature vous met très rapidement à terre. Vous entendez un dernier cri de la créature, et soudain, plus rien.',
'choice' => array(
        array('text' => 'Continuer', 'goto' => 0)
    )
),
array('text' => 'Vous reculez, présentant vos paumes à la créature, bredouillant que vous ne cherchez pas le conflit, mais avant que vous ne finissiez votre tirade, la créature vous interrompt, sa voix résonnant plus dans votre tête que dans la salle : "Pain au chocolat ou chocolatine?"',
'choice' => array(
        array('text' => 'Chocolatine', 'goto' => 22),
        array('text' => 'Pain au chocolat', 'goto' => 23)
    )
),
array('text' => 'Vous mourrez sur le coup. Na.',
'choice' => array(
        array('text' => 'Recommencer', 'goto' => 0)
    )
),
array('text' => 'La créature hoche lentement sa tête sans visage, puis disparait. Devant vous une porte s\'ouvre, révélant un nouveau couloir.',
'choice' => array(
        array('text' => 'Entrer dans le couloir', 'goto' => 26),
        array('text' => 'Crier "chocolatine!"', 'goto' => 22)
    )
),
array('text' => 'Vous emptrutez une feuille et un crayon au designer, et vous mettez à dessiner à l\'abris de la vue du designer. Ce dernier, curieux, attend que vous ayez fini. Quand vous lui montrez enfin votre oeuvre, il écarquille, se met à hurler, et fini par se consummer, apparement de l\'intérieur. Votre sens artistique discutable vous aura finalement sauvé la vie.',
'choice' => array(
        array('text' => 'Continuer dans le couloir', 'goto' => 26)
    )
),
array('text' => 'En voyant les croquis du designer, vous savez déjà ce qu\'il va demander. Vous ne pouvez plus l\'éviter. Vous allez devoir intégrer un design impossible. Le temps que vous finnissiez, les gardes vont vous retrouver',
'choice' => array(
        array('text' => 'Pleurer', 'goto' => 0)
    )
),
array('text' => 'Après avoir parcouru des couloirs labyrinthiques pendant une dizaine de minutes, vous arrivez enfin devant une sortie. Vous avez retrouvé la liberté.
Félicitations! Maintenant que vous avez terminé ce jeu, retournez bosser.',
'choice' => array(
        array('text' => 'Faire une nouvelle partie', 'goto' => 0)
    )
)
);