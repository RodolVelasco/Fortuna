<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;

class EventosInstitucionalesType extends AbstractType
{
    /**
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nombreInstitucion')
        ->add('direccionResponsablePrograma')
        ->add('nombrePrograma')
        ->add('nombreContactoResponsablePrograma')
        ->add('telefonoContactoResponsablePrograma')
        ->add('emailContactoResponsablePrograma')
        ->add('actividad')
        ->add('departamento', ChoiceType::class, array(
            'attr' => array(
                'class' => ''
            ),
            'choices'  => array(
                'Ahuachapán' => array(
                    "Ahuachapán"=>"Ahuachapán - Ahuachapán",
                    "Atiquizaya"=>"Ahuachapán - Atiquizaya",
                    "San Francisco Menéndez"=>"Ahuachapán - San Francisco Menéndez",
                    "Tacuba"=>"Ahuachapán - Tacuba",
                    "Concepción De Ataco"=>"Ahuachapán - Concepción De Ataco",
                    "Jujutla"=>"Ahuachapán - Jujutla",
                    "Guaymango"=>"Ahuachapán - Guaymango",
                    "Apaneca"=>"Ahuachapán - Apaneca",
                    "San Pedro Puxtla"=>"Ahuachapán - San Pedro Puxtla",
                    "San Lorenzo"=>"Ahuachapán - San Lorenzo",
                    "Turin"=>"Ahuachapán - Turin",
                    "El Refugio"=>"Ahuachapán - El Refugio",
                ),
                'Cabañas' => array(
                    "Sensuntepeque"=>"Cabañas - Sensuntepeque",
                    "Ilobasco"=>"Cabañas - Ilobasco",
                    "Victoria"=>"Cabañas - Victoria",
                    "San Isidro"=>"Cabañas - San Isidro",
                    "Jutiapa"=>"Cabañas - Jutiapa",
                    "Tejutepeque"=>"Cabañas - Tejutepeque",
                    "Dolores"=>"Cabañas - Dolores",
                    "Cinquera"=>"Cabañas - Cinquera",
                    "Guacotecti"=>"Cabañas - Guacotecti",
                ),
                'Chalatenango' => array(
                    "Chalatenango"=>"Chalatenango - Chalatenango",
                    "Nueva Concepcion"=>"Chalatenango - Nueva Concepcion",
                    "La Palma"=>"Chalatenango - La Palma",
                    "Tejutla"=>"Chalatenango - Tejutla",
                    "La Reina"=>"Chalatenango - La Reina",
                    "Arcatao"=>"Chalatenango - Arcatao",
                    "San Ignacio"=>"Chalatenango - San Ignacio",
                    "Dulce Nombre De Maria"=>"Chalatenango - Dulce Nombre De Maria",
                    "Citala"=>"Chalatenango - Citala",
                    "Agua Caliente"=>"Chalatenango - Agua Caliente",
                    "Concepcion Quezaltepeque"=>"Chalatenango - Concepcion Quezaltepeque",
                    "Nueva Trinidad"=>"Chalatenango - Nueva Trinidad",
                    "Las Vueltas"=>"Chalatenango - Las Vueltas",
                    "Comalapa"=>"Chalatenango - Comalapa",
                    "San Rafael"=>"Chalatenango - San Rafael",
                    "Las Flores"=>"Chalatenango - Las Flores",
                    "Ojos De Agua"=>"Chalatenango - Ojos De Agua",
                    "Nombre De Jesus"=>"Chalatenango - Nombre De Jesus",
                    "Potonico"=>"Chalatenango - Potonico",
                    "San Francisco Morazan"=>"Chalatenango - San Francisco Morazan",
                    "Santa Rita"=>"Chalatenango - Santa Rita",
                    "La Laguna"=>"Chalatenango - La Laguna",
                    "San Isidro Labrador"=>"Chalatenango - San Isidro Labrador",
                    "San Antonio De La Cruz"=>"Chalatenango - San Antonio De La Cruz",
                    "El Paraiso"=>"Chalatenango - El Paraiso",
                    "San Miguel De Mercedes"=>"Chalatenango - San Miguel De Mercedes",
                    "San Luis Del Carmen"=>"Chalatenango - San Luis Del Carmen",
                    "San Jose Cancasque"=>"Chalatenango - San Jose Cancasque",
                    "San Antonio Los Ranchos"=>"Chalatenango - San Antonio Los Ranchos",
                    "El Carrizal"=>"Chalatenango - El Carrizal",
                    "San Fernando"=>"Chalatenango - San Fernando",
                    "Azacualpa"=>"Chalatenango - Azacualpa",
                    "San Francisco Lempa"=>"Chalatenango - San Francisco Lempa",
                ),
                'Cuscatlán' => array(
                    "Cojutepeque"=>"Cuscatlán - Cojutepeque",
                    "Suchitoto"=>"Cuscatlán - Suchitoto",
                    "San Pedro Perulapan"=>"Cuscatlán - San Pedro Perulapan",
                    "San Jose Guayabal"=>"Cuscatlán - San Jose Guayabal",
                    "Tenancingo"=>"Cuscatlán - Tenancingo",
                    "San Rafael Cedros"=>"Cuscatlán - San Rafael Cedros",
                    "Candelaria"=>"Cuscatlán - Candelaria",
                    "El Carmen"=>"Cuscatlán - El Carmen",
                    "Monte San Juan"=>"Cuscatlán - Monte San Juan",
                    "San Cristobal"=>"Cuscatlán - San Cristobal",
                    "Santa Cruz Michapa"=>"Cuscatlán - Santa Cruz Michapa",
                    "San Bartolome Perulapia"=>"Cuscatlán - San Bartolome Perulapia",
                    "San Ramon"=>"Cuscatlán - San Ramon",
                    "El Rosario"=>"Cuscatlán - El Rosario",
                    "Oratorio De Concepcion"=>"Cuscatlán - Oratorio De Concepcion",
                    "Santa Cruz Analquito"=>"Cuscatlán - Santa Cruz Analquito",
                ),
                'La Libertad' => array(
                    "Santa Tecla"=>"La Libertad - Santa Tecla",
                    "Quezaltepeque"=>"La Libertad - Quezaltepeque",
                    "Ciudad Arce"=>"La Libertad - Ciudad Arce",
                    "San Juan Opico"=>"La Libertad - San Juan Opico",
                    "Colon"=>"La Libertad - Colon",
                    "La Libertad"=>"La Libertad - La Libertad",
                    "Antiguo Cuscatlan"=>"La Libertad - Antiguo Cuscatlan",
                    "Comasagua"=>"La Libertad - Comasagua",
                    "San Pablo Tacachico"=>"La Libertad - San Pablo Tacachico",
                    "Jayaque"=>"La Libertad - Jayaque",
                    "Huizucar"=>"La Libertad - Huizucar",
                    "Tepecoyo"=>"La Libertad - Tepecoyo",
                    "Teotepeque"=>"La Libertad - Teotepeque",
                    "Chiltiupan"=>"La Libertad - Chiltiupan",
                    "Nuevo Cuscatlan"=>"La Libertad - Nuevo Cuscatlan",
                    "Tamanique"=>"La Libertad - Tamanique",
                    "Sacacoyo"=>"La Libertad - Sacacoyo",
                    "San Jose Villanueva"=>"La Libertad - San Jose Villanueva",
                    "Zaragoza"=>"La Libertad - Zaragoza",
                    "Talnique"=>"La Libertad - Talnique",
                    "San Matias"=>"La Libertad - San Matias",
                    "Jicalapa"=>"La Libertad - Jicalapa",
                ),
                'La Paz' => array(
                    "Zacatecoluca"=>"La Paz - Zacatecoluca",
                    "Santiago Nonualco"=>"La Paz - Santiago Nonualco",
                    "San Juan Nonualco"=>"La Paz - San Juan Nonualco",
                    "San Pedro Masahuat"=>"La Paz - San Pedro Masahuat",
                    "Olocuilta"=>"La Paz - Olocuilta",
                    "San Pedro Nonualco"=>"La Paz - San Pedro Nonualco",
                    "San Francisco Chinameca"=>"La Paz - San Francisco Chinameca",
                    "San Juan Talpa"=>"La Paz - San Juan Talpa",
                    "El Rosario"=>"La Paz - El Rosario",
                    "San Rafael Obrajuelo"=>"La Paz - San Rafael Obrajuelo",
                    "Santa Maria Ostuma"=>"La Paz - Santa Maria Ostuma",
                    "San Luis Talpa"=>"La Paz - San Luis Talpa",
                    "San Antonio Masahuat"=>"La Paz - San Antonio Masahuat",
                    "San Miguel Tepezontes"=>"La Paz - San Miguel Tepezontes",
                    "San Juan Tepezontes"=>"La Paz - San Juan Tepezontes",
                    "Tapalhuaca"=>"La Paz - Tapalhuaca",
                    "Cuyultitan"=>"La Paz - Cuyultitan",
                    "Paraiso De Osorio"=>"La Paz - Paraiso De Osorio",
                    "San Emigdio"=>"La Paz - San Emigdio",
                    "Jerusalen"=>"La Paz - Jerusalen",
                    "Mercedes La Ceiba"=>"La Paz - Mercedes La Ceiba",
                    "San Luis La Herradura"=>"La Paz - San Luis La Herradura",
                ),
                'La Unión' => array(
                    "La Union"=>"La Union - La Union",
                    "Santa Rosa De Lima"=>"La Union - Santa Rosa De Lima",
                    "Pasaquina"=>"La Union - Pasaquina",
                    "San Alejo"=>"La Union - San Alejo",
                    "Anamoros"=>"La Union - Anamoros",
                    "El Carmen"=>"La Union - El Carmen",
                    "Conchagua"=>"La Union - Conchagua",
                    "El Sauce"=>"La Union - El Sauce",
                    "Lislique"=>"La Union - Lislique",
                    "Yucuaiquin"=>"La Union - Yucuaiquin",
                    "Nueva Esparta"=>"La Union - Nueva Esparta",
                    "Poloros"=>"La Union - Poloros",
                    "Bolivar"=>"La Union - Bolivar",
                    "Concepcion De Oriente"=>"La Union - Concepcion De Oriente",
                    "Intipuca"=>"La Union - Intipuca",
                    "San Jose Las Fuentes"=>"La Union - San Jose Las Fuentes",
                    "Yayantique"=>"La Union - Yayantique",
                    "Meanguera Del Golfo"=>"La Union - Meanguera Del Golfo",
                ),
                'Morazán' => array(
                    "San Francisco Gotera"=>"Morazán - San Francisco Gotera",
                    "Jocoro"=>"Morazán - Jocoro",
                    "Corinto"=>"Morazán - Corinto",
                    "Sociedad"=>"Morazán - Sociedad",
                    "Cacaopera"=>"Morazán - Cacaopera",
                    "Guatajiagua"=>"Morazán - Guatajiagua",
                    "El Divisadero"=>"Morazán - El Divisadero",
                    "Jocoaitique"=>"Morazán - Jocoaitique",
                    "Osicala"=>"Morazán - Osicala",
                    "Chilanga"=>"Morazán - Chilanga",
                    "Meanguera"=>"Morazán - Meanguera",
                    "Torola"=>"Morazán - Torola",
                    "San Simon"=>"Morazán - San Simon",
                    "Delicias De Concepcion"=>"Morazán - Delicias De Concepcion",
                    "Joateca"=>"Morazán - Joateca",
                    "Arambala"=>"Morazán - Arambala",
                    "Lolotiquillo"=>"Morazán - Lolotiquillo",
                    "Yamabal"=>"Morazán - Yamabal",
                    "Yoloaiquin"=>"Morazán - Yoloaiquin",
                    "San Carlos"=>"Morazán - San Carlos",
                    "El Rosario"=>"Morazán - El Rosario",
                    "Perquin"=>"Morazán - Perquin",
                    "Sensembra"=>"Morazán - Sensembra",
                    "Gualococti"=>"Morazán - Gualococti",
                    "San Fernando"=>"Morazán - San Fernando",
                    "San Isidro"=>"Morazán - San Isidro",
                ),
                'San Miguel' => array(
                    "San Miguel"=>"San Miguel - San Miguel",
                    "Chinameca"=>"San Miguel - Chinameca",
                    "El Transito"=>"San Miguel - El Transito",
                    "Ciudad Barrios"=>"San Miguel - Ciudad Barrios",
                    "Chirilagua"=>"San Miguel - Chirilagua",
                    "Sesori"=>"San Miguel - Sesori",
                    "San Rafael Oriente"=>"San Miguel - San Rafael Oriente",
                    "Moncagua"=>"San Miguel - Moncagua",
                    "Lolotique"=>"San Miguel - Lolotique",
                    "San Jorge"=>"San Miguel - San Jorge",
                    "Chapeltique"=>"San Miguel - Chapeltique",
                    "San Gerardo"=>"San Miguel - San Gerardo",
                    "Carolina"=>"San Miguel - Carolina",
                    "Quelepa"=>"San Miguel - Quelepa",
                    "San Luis De La Reina"=>"San Miguel - San Luis De La Reina",
                    "Nuevo Eden De San Juan"=>"San Miguel - Nuevo Eden De San Juan",
                    "Nueva Guadalupe"=>"San Miguel - Nueva Guadalupe",
                    "Uluazapa"=>"San Miguel - Uluazapa",
                    "Comacaran"=>"San Miguel - Comacaran",
                    "San Antonio Del Mosco"=>"San Miguel - San Antonio Del Mosco",
                ),
                'San Salvador' => array(
                    "San Salvador"=>"San Salvador - San Salvador",
                    "Ciudad Delgado"=>"San Salvador - Ciudad Delgado",
                    "Mejicanos"=>"San Salvador - Mejicanos",
                    "Soyapango"=>"San Salvador - Soyapango",
                    "Cuscatancingo"=>"San Salvador - Cuscatancingo",
                    "San Marcos"=>"San Salvador - San Marcos",
                    "Ilopango"=>"San Salvador - Ilopango",
                    "Nejapa"=>"San Salvador - Nejapa",
                    "Apopa"=>"San Salvador - Apopa",
                    "San Martin"=>"San Salvador - San Martin",
                    "Panchimalco"=>"San Salvador - Panchimalco",
                    "Aguilares"=>"San Salvador - Aguilares",
                    "Tonacatepeque"=>"San Salvador - Tonacatepeque",
                    "Santo Tomas"=>"San Salvador - Santo Tomas",
                    "Santiago Texacuangos"=>"San Salvador - Santiago Texacuangos",
                    "El Paisnal"=>"San Salvador - El Paisnal",
                    "Guazapa"=>"San Salvador - Guazapa",
                    "Ayutuxtepeque"=>"San Salvador - Ayutuxtepeque",
                    "Rosario De Mora"=>"San Salvador - Rosario De Mora",
                ),
                'San Vicente' => array(
                    "San Vicente"=>"San Vicente - San Vicente",
                    "Tecoluca"=>"San Vicente - Tecoluca",
                    "San Sebastian"=>"San Vicente - San Sebastian",
                    "Apastepeque"=>"San Vicente - Apastepeque",
                    "San Esteban Catarina"=>"San Vicente - San Esteban Catarina",
                    "San Ildefonso"=>"San Vicente - San Ildefonso",
                    "Santa Clara"=>"San Vicente - Santa Clara",
                    "San Lorenzo"=>"San Vicente - San Lorenzo",
                    "Verapaz"=>"San Vicente - Verapaz",
                    "Guadalupe"=>"San Vicente - Guadalupe",
                    "Santo Domingo"=>"San Vicente - Santo Domingo",
                    "San Cayetano Istepeque"=>"San Vicente - San Cayetano Istepeque",
                    "Tepetitan"=>"San Vicente - Tepetitan",
                ),
                'Santa Ana' => array(
                    "Santa Ana"=>"Santa Ana - Santa Ana",
                    "Chalchuapa"=>"Santa Ana - Chalchuapa",
                    "Metapan"=>"Santa Ana - Metapan",
                    "Coatepeque"=>"Santa Ana - Coatepeque",
                    "El Congo"=>"Santa Ana - El Congo",
                    "Texistepeque"=>"Santa Ana - Texistepeque",
                    "Candelaria De La Frontera"=>"Santa Ana - Candelaria De La Frontera",
                    "San Sebastian Salitrillo"=>"Santa Ana - San Sebastian Salitrillo",
                    "Santa Rosa Guachipilin"=>"Santa Ana - Santa Rosa Guachipilin",
                    "Santiago De La Frontera"=>"Santa Ana - Santiago De La Frontera",
                    "El Porvenir"=>"Santa Ana - El Porvenir",
                    "Masahuat"=>"Santa Ana - Masahuat",
                    "San Antonio Pajonal"=>"Santa Ana - San Antonio Pajonal",
                ),
                'Sonsonate' => array(
                    "Sonsonate"=>"Sonsonate - Sonsonate",
                    "Izalco"=>"Sonsonate - Izalco",
                    "Acajutla"=>"Sonsonate - Acajutla",
                    "Armenia"=>"Sonsonate - Armenia",
                    "Nahuizalco"=>"Sonsonate - Nahuizalco",
                    "Juayua"=>"Sonsonate - Juayua",
                    "San Julian"=>"Sonsonate - San Julian",
                    "Sonzacate"=>"Sonsonate - Sonzacate",
                    "San Antonio Del Monte"=>"Sonsonate - San Antonio Del Monte",
                    "Nahuilingo"=>"Sonsonate - Nahuilingo",
                    "Cuisnahuat"=>"Sonsonate - Cuisnahuat",
                    "Santa Catarina Masahuat"=>"Sonsonate - Santa Catarina Masahuat",
                    "Caluco"=>"Sonsonate - Caluco",
                    "Santa Isabel Ishuatan"=>"Sonsonate - Santa Isabel Ishuatan",
                    "Salcoatitan"=>"Sonsonate - Salcoatitan",
                    "Santo Domingo De Guzman"=>"Sonsonate - Santo Domingo De Guzman",
                ),
                'Usulután' => array(
                    "Usulutan"=>"Usulután - Usulutan",
                    "Jiquilisco"=>"Usulután - Jiquilisco",
                    "Berlin"=>"Usulután - Berlin",
                    "Santiago De Maria"=>"Usulután - Santiago De Maria",
                    "Jucuapa"=>"Usulután - Jucuapa",
                    "Santa Elena"=>"Usulután - Santa Elena",
                    "Jucuaran"=>"Usulután - Jucuaran",
                    "San Agustin"=>"Usulután - San Agustin",
                    "Ozatlan"=>"Usulután - Ozatlan",
                    "Estanzuelas"=>"Usulután - Estanzuelas",
                    "Mercedes Umaña"=>"Usulután - Mercedes Umaña",
                    "Alegria"=>"Usulután - Alegria",
                    "Concepcion Batres"=>"Usulután - Concepcion Batres",
                    "San Francisco Javier"=>"Usulután - San Francisco Javier",
                    "Puerto El Triunfo"=>"Usulután - Puerto El Triunfo",
                    "Tecapan"=>"Usulután - Tecapan",
                    "San Dionisio"=>"Usulután - San Dionisio",
                    "Ereguayquin"=>"Usulután - Ereguayquin",
                    "Santa Maria"=>"Usulután - Santa Maria",
                    "Nueva Granada"=>"Usulután - Nueva Granada",
                    "El Triunfo"=>"Usulután - El Triunfo",
                    "San Buenaventura"=>"Usulután - San Buenaventura",
                    "California"=>"Usulután - California",
                ),
            ),
            )
        )
        ->add('lugar')
        ->add('fecha', DateType::class, array(
                'widget' => 'single_text',
                'html5'  => false,
                'attr' => array(
                    'class' => ''
                )
            )
        )
        ->add('hora', ChoiceType::class, array(
            'choices'  => array(
                '07' => "07",
                '08' => "08",
                '09' => "09",
                '10' => "10",
                '11' => "11",
                '12' => "12",
                '13' => "13",
                '14' => "14",
                '15' => "15",
                '16' => "16",
                '17' => "17",
                '18' => "18",
            ),
        )
        )
        ->add('minuto', ChoiceType::class, array(
            'choices'  => array(
                '00' => "00",
                '05' => "05",
                '10' => "10",
                '15' => "15",
                '20' => "20",
                '25' => "25",
                '30' => "30",
                '35' => "35",
                '45' => "45",
                '50' => "50",
                '55' => "55",
            ),
        )
        )
        ->add('poblacionObjetivo')
        ->add('numeroParticipantes', IntegerType::class, array(
            //'label' => 'Your label here',
            //'empty_data' => 0, // default value
            //'precision' => 0, // disallow floats
            'attr' => array('min' => 1, 'max' => 10000)
            /*'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Type('integer'),
                new Assert\Regex(array(
                        'pattern' => '/^[0-9]\d*$/',
                        'message' => 'Favor ingresar sólo números positivos.'
                    )
                ),*/
                //new Assert\Length(array('max' => 3))
            )
        )
        ->add('nombreContactoResponsableActividad')
        ->add('telefonoContactoResponsableActividad')
        ->add('emailContactoResponsableActividad')
        ;
    }

    /**
    * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\EventosInstitucionales'
        ));
    }


}
