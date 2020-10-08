<?php
	try{
		session_start();
		require('controller/controller.php');
		

		if(isset($_GET['page']) && !empty($_GET['page'])){
			switch($_GET['page']){
				case 'administration':
				case 'evenements':
				case 'profil':
					get_sqldata_view($_GET['page']);
				break;
				case 'modification':
				case 'spectacle':
					$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : null;
					get_sqldata_view($_GET['page'], $_GET['id']);
				break;
				case 'lieux':
				case 'contacts':
					get_jsondata_view($_GET['page']);
				break;
				default:
					get_view($_GET['page']);
				break;
			}	
		}
		else get_view();

	}
	catch(Exception $e){
		get_view('erreur', null, $e->getMessage());
	}
?>