<?php
require_once('lib/includeLibs.php');
require_once('class/item.class.php');

$class = new manage_item;

    switch ($_GET['action'])
	{
		case "delete":
			$class->deleteItem($_GET['id']);
		break;
        case "saveItem";
            $class->saveNewItem();
        break;
        case "saveUpdateItem";
            $class->saveUpdateItem($_GET['id']);
        break;
        case "modify":
            echo $class->updateItem($_GET['id']);
            exit();
        break;
        case "addnew":
            echo $class->displaycontentadd();
            exit();
        break;
    }

echo $class->Display();
?>