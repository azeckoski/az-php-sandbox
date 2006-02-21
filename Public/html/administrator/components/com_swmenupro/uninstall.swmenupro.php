<?php
/**
* SWMenuPro v1.0
* http://swonline.biz
* DHTML Menu Component for Mambo Open Source
* Mambo Open Source is Free Software
* Released under GNU/GPL License: http://www.gnu.org/copyleft/gpl.html
**/

function com_uninstall()
{
        $retstr = SWmenuProRemove();
        return "SWmenuPro uninstalled succesfully<br /> $retstr";
}


function SWmenuProRemove () {
        global $database;
        $retstr = '';

        $query = "SELECT id, title, module, params FROM #__modules WHERE module='mod_swmenupro'";

        $database->setQuery( $query );
        $modules = $database->loadObjectList();
        if ($database->getErrorNum()) {
                $retstr .= "MA ".$database->stderr(true);
                return $retstr;
        }
        foreach ($modules as $module) {
               
                $sql = "DELETE FROM #__modules WHERE id='$module->id'";
                $database->setQuery($sql);
                $database->query();
        }
        return $retstr;
}


?>

