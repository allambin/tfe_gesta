<?php

namespace Cranberry;

use Fuel\Core\Asset;

class MyXML 
{
    /**
     * Loads the specified xml
     * @param string $file  xml filename (without extension)
     * @return type
     */
    public static function getXML($file)
    {
        $xml = self::loadXML($file);
        
        switch ($file)
        {
            case 'pays':
                return self::computePays($xml);
                break;
            case 'fin_formation':
                return self::computeFinFormation($xml);
                break;
            case 'statut_entree':
                return self::computeStatutEntree($xml);
                break;
            case 'enseignement':
                return self::computeEnseignement($xml);
                break;
            default:
                return $xml;
                break;
        }
    }
    
    /**
     * Returns one xml node
     * @param string $file  xml filename (without extension)
     * @param mixed $item
     * @return type
     */
    public static function getXMLItem($file, $item)
    {
        $xml = self::loadXML($file);
        
        switch ($file)
        {
            case 'coordonnees':
                $item = (int) $item;
                return $xml->centre[$item];
                break;
            default:
                return $xml->$item;
                break;
        }
    }
    
    /**
     * Edit the specified xml node
     * @param string $file    xml filename (without extension)
     * @param int $item
     * @param mixed $value
     */
    public static function editXMLItem($file, $item, $value)
    {
        $path = Asset::find_file($file.'.xml', 'xml');
        $xml = self::loadXML($file);

        //on supprime l'item
        unset($xml->$item);
        //on le recrée avec le nouveau
        $xml->addChild($item, $value);
        $xml->asXML($path);
    }
    
    /**
     * Loads an xml
     * @param string $file    xml filename (without extension)
     * @return type
     */
    private static function loadXML($file)
    {
        $path = Asset::find_file($file.'.xml', 'xml');
        return simplexml_load_file($path);
    }
    
    /**
     * Deletes specified xml node
     * @param string $object  xml filename (without extension)
     * @param string $node
     * @param int $item
     * @param string $subnode
     */
    public static function deleteNode($file, $node, $item, $subnode = null)
    {
        $path = Asset::find_file($file.'.xml', 'xml');
        $xml = self::loadXML($file);

        $item = (int) $item;
        
        if($subnode)
        {
            unset($xml->$node->{$subnode}[$item]);
        }
        else
        {
            unset($xml->$node->$item);
        }
        $xml->asXML($path);
    }
    
    /**
     * Adds a xml node
     * @param string $file xml filename  (without extension)
     * @param string $name
     * @param string $value
     * @param string $childname
     * @param string $nodename
     */
    public static function addNode($file, $name, $value , $childname, $nodename = null)
    {
        $path = Asset::find_file($file.'.xml', 'xml');
        $xml = self::loadXML($file);       
        
        if($nodename)
        {
            $node = $xml->{$nodename}->addChild($childname);
        }
        else
        {
            $node = $xml->addChild($childname);
        }
        
        $node->addChild('nom', $name);
        $node->addChild('valeur', $value);
        $xml->asXML($path);
    }
    
    /**
     * Returns fin formation array
     * @param SimpleXML $xml
     * @return type
     */
    private static function computeFinFormation($xml)
    {
        $array = array(
            'fin_formations' => $xml->fin,
            'suite_formations' => $xml->suite,
            'autres' => $xml->autre,
            'wallonie' => $xml->wallonie,
            'bruxelles' => $xml->bruxelles
        );

        return $array;
    }
    
    /**
     * Returns pays array
     * @param SimpleXML $xml
     * @return type
     */
    private static function computePays($xml)
    {
        return array(
            "" => "",
            "Belgique" => $xml->belgique->pays,
            "Europe" => $xml->europe->pays,
            "Hors Europe" => $xml->hors_europe->pays,
            "Autre" => $xml->autre->pays,
        );
    }
    
    /**
     * Returns enseignement array
     * @param SimpleXML $xml
     * @return type
     */
    private static function computeEnseignement($xml) 
    {
        $tab_diplome = array();
        $tab_diplome_size = count($xml->diplome);
        for ($i = 0; $i < $tab_diplome_size; $i++) 
        {
            $tab_diplome['' . $xml->diplome[$i]->valeur . ''] = $xml->diplome[$i]->nom;
        }
        
        $tab_type = array();
        $tab_type_size = count($xml->type);
        for ($i = 0; $i < $tab_type_size; $i++) {
            $tab_type['' . $xml->type[$i]->valeur . ''] = $xml->type[$i]->nom;
        }

        return array(
            "" => "",
            "Diplome" => $tab_diplome,
            "Type" => $tab_type
        );
    }
    
    /**
     * Returns statut entree array
     * @param SimpleXML $xml
     * @return type
     */
    private static function computeStatutEntree($xml) 
    {
        $array = array(
            "emploi" => $xml->personne_en_emploi->statut,
            "demandeur" => $xml->demandeur_emploi_inscrit->statut,
            "etudiant" => $xml->etudiant->statut,
            "autres" => $xml->autres->statut
        );

        return $array;
    }

    /**
     * Récupérer la valeur associée au nom du pays
     *
     * @param type $nom
     * @return type 
     */
    public static function get_valeurPays($nom) 
    {
        $path = Asset::find_file('pays.xml', 'xml');
        $xml = simplexml_load_file($path);

        foreach ($xml->hors_europe->pays as $info) {
            if ((string) utf8_decode(trim($info->nom)) == (string) utf8_decode(trim($nom))) {
                return $info->valeur;
            }
        }
        foreach ($xml->europe->pays as $info) {
            if ((string) utf8_decode(trim($info->nom)) == (string) utf8_decode(trim($nom))) {
                return $info->valeur;
            }
        }
        foreach ($xml->belgique->pays as $info) {
            if ((string) utf8_decode(trim($info->nom)) == (string) utf8_decode(trim($nom))) {
                return $info->valeur;
            }
        }
        foreach ($xml->autre->pays as $info) {
            if ((string) utf8_decode(trim($info->nom)) == (string) utf8_decode(trim($nom))) {
                return $info->valeur;
            }
        }
    }
    
    /**
     * Returns a select-like array
     * @return array
     */
    public static function getPaysAsSelect()
    {
        $pays = self::getXML('pays');
        
        $select = array();
        $select['Belgique']= array();
        $select['Europe']= array();
        $select['Hors Europe']= array();
        $select['Autre']= array();
        foreach ($pays['Belgique'] as $p)
        {
            $select['Belgique'][(string)$p->nom] = $p->nom;
        }
        
        foreach ($pays['Europe'] as $p)
        {
            $select['Europe'][(string)$p->nom] = $p->nom;
        }
        
        foreach ($pays['Hors Europe'] as $p)
        {
            $select['Hors Europe'][(string)$p->nom] = $p->nom;
        }
        
        foreach ($pays['Autre'] as $p)
        {
            $select['Autre'][(string)$p->nom] = $p->nom;
        }
        
        return $select;
    }

    /**
     * Renvoie le tableau contenant les années d'étude
     *
     * @return type 
     */
    public static function get_annee_etude() 
    {
        $tab_annee_etude = array();
        $tab_annee_etude["1ère année secondaire"] = "1ère année secondaire";
        $tab_annee_etude["2ième année secondaire"] = "2ième année secondaire";
        $tab_annee_etude["3ième générale réussie"] = "3ième générale réussie";
        $tab_annee_etude["3ième technique réussie"] = "3ième technique réussie";
        $tab_annee_etude["3ième professionnel réussie"] = "3ième professionnel réussie";
        $tab_annee_etude["3ième professionel non réussie"] = "3ième professionel non réussie";
        $tab_annee_etude["4ième générale réussie"] = "4ième générale réussie";
        $tab_annee_etude["4ième technique réussie"] = "4ième technique réussie";
        $tab_annee_etude["4ième professionel réussie"] = "4ième professionel réussie";
        $tab_annee_etude["4ième professionel non réussie"] = "4ième professionel non réussie";
        $tab_annee_etude["5ième général réussie"] = "5ième général réussie";
        $tab_annee_etude["5ième technique réussie"] = "5ième technique réussie";
        $tab_annee_etude["5ième professionnel réussie"] = "5ième professionnel réussie";
        $tab_annee_etude["5ième profession non réussie"] = "5ième profession non réussie";
        $tab_annee_etude["6ième général réussie"] = "6ième général réussie";
        $tab_annee_etude["6ième technique réussie"] = "6ième technique réussie";
        $tab_annee_etude["6ième professionel réussie"] = "6ième professionel réussie";
        $tab_annee_etude["6ième professionel non réussie"] = "6ième professionel non réussie";
        $tab_annee_etude["IFAPME 1 an"] = "IFAPME 1 an";
        $tab_annee_etude["IFAPME 2 ans"] = "IFAPME 2 ans";
        $tab_annee_etude["CEFA 1 an"] = "CEFA 1 an";
        $tab_annee_etude["CEFA 2 ans"] = "CEFA 2 ans";
        $tab_annee_etude["CEFA 3 ans"] = "CEFA 3 ans";
        $tab_annee_etude["Autre"] = "Autre";

        return array(
            "" => "",
            "Année étude" => $tab_annee_etude
        );
    }

    /**
     * Récupère les coordonnées
     *
     * @return type 
     */
    public static function getCoordonnees() 
    {
        $path = Asset::find_file('coordonnees.xml', 'xml');
        $xml = simplexml_load_file($path);

        return $xml;
    }

    /**
     * Ajoute un pack de coordonnees
     *
     * @param type $param
     * @param type $valeur 
     */
    public static function editCentre($centre, $item = null) 
    {
        $path = Asset::find_file('coordonnees.xml', 'xml');
        $xml = simplexml_load_file($path);

        if ($item !== null) 
        {
            //on supprime l'item
            $item = (int) $item;
            unset($xml->centre->$item);
        
        }
        
        $statut = $xml->addChild('centre');
        $statut->addChild('responsable', utf8_encode($centre['responsable']));
        $statut->addChild('statut', $centre['statut']);
        $statut->addChild('denomination', $centre['denomination']);
        $statut->addChild('nom_centre', $centre['nom_centre']);
        $statut->addChild('objet_social', $centre['objet_social']);
        $statut->addChild('agregation', $centre['agregation']);
        $statut->addChild('agence', $centre['agence']);
        $statut->addChild('adresse', $centre['adresse']);
        $statut->addChild('code_postal', $centre['code_postal']);
        $statut->addChild('localite', $centre['localite']);
        $statut->addChild('telephone', $centre['telephone']);
        $statut->addChild('email', $centre['email']);
        $statut->addChild('tva', $centre['tva']);
        $statut->addChild('enregistrement', $centre['enregistrement']);
        $statut->addChild('agrement', $centre['agrement']);
        $statut->addChild('responsable_pedagogique', $centre['responsable_pedagogique']);
        $statut->addChild('secretaire', $centre['secretaire']);
        $xml->asXML($path);
    }

}

?>
