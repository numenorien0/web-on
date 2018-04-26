# pilot::isConnected() 
Retourne le statut de connnexion de l'internaute.
retourne true si il est connecté au CMS ou false s'il ne l'est pas.

# pilot::get_filetype()
Retourne le MIME TYPE d'un fichier donné. 

exemple 
`echo pilot::get_filetype("monImage.jpg");`

Retournera "image/jpg"

# pilot::get_favicon()
Retournera le chemin du fichier favicon du site internet.

# pilot::get_base()
Retournera le chemin du dossier de travail courant du site internet

# pilot::get_theme_path()
Retournera le chemin vers le dossier de thème actuellement utilisé.

exemple 
`echo pilot::get_theme_path();`

Retournera 
"CMS/themes/monTheme/"

# pilot::get_featured_image(id)
Retournera l'image actuel d'une page selon un id ou un slug

# pilot::get_id()
Retourne l'ID de la page courante

# pilot::get_main_language()
retourne la langue principale du site sous form iso (ex: "fr").

# pilot::get_topbar()
Retourne le fichier html de la topbar

# pilot::get_social()
retourne les réseaux sociaux du site web sous forme JSON

exemple : 
`print_r(pilot::get_social());`

retournera

`Array
(
    [facebook] => "http://facebook.com/myPage"
    [twitter] => "http://twitter.com/myProfile"
    [instagram] => ""
    [gplus] => ""
    [linkedin] => ""
    [Pinterest] => ""
)
		`

# pilot::get_site_title()
retourne le nom du site internet

# pilot::get_skin()
retourne le nom (du dossier) du theme courant

# pilot::get_logo()
Retourne le chemin du logo du site internet

# pilot::get_id_from_slug(slug)

Retourne l'id d'une page à partir d'un slug d'une page.

exemple : 

`echo pilot::get_id_from_slug("c-est-ma-page.html");`

Retournera 

22

# pilot::execute_php(string)

**A utiliser avec prudence !** C'est une fonction qui execute le PHP à partir d'une chaine de caractère. Elle effectue automatiquement un "ECHO" en PHP. Cette fonction ne doit être utilisée que si vraiment il n'y a pas d'autres alternatives.

# pilot::do_shortcode(string)

Cette fonction parse la chaine de caractère et remplace les shortcodes présents dedans par les plugins correspondants.

# pilot::get_breadcrumb(id)

Cette fonction retourne un tableau de l'arborescence du site de la page d'accueil jusqu'a à la page actuelle ou jusqu'à la page contenant l'id renseigné en paramètre.

# pilot::get_pages(array)

## arguments

array(ID => "", "name" => "","images" => image quality(full | HD | SD | intermediate | thumb) ,"keywords" => "", "parent" => "", "orderBy" => "ID", "sort" => "ASC", "limit" => "100000", "offset" => "0")

Cette fonction retourne une page selon les filtres choisis.
Aucun champs n'est obligatoire.

La fonction 
`$pilot->get_pages(array("image" => "SD", "ID" => 98));`

retournera un tableau comme suit : 

`Array
(
    [0] => Array
        (
            [ID] => 98
            [name] => Accueil
            [description] => dd
            [text] => [shortcode plugin=galerie id=11 height=500px]
            [parent] => 
            [author] => antoine
            [date] => 1523353748
            [image] => CMS/content/images/201804/800x415-1523944381.jpg
            [online] => on
            [commentaire] => off
            [update_auteur] => antoine
            [update_date] => 1523950876
            [keywords] => 
            [orderID] => 4
            [customFields] => Array
               (
                    [button] => click me !
                )
            [permalink] => accueil
            [homepage] => on
            [display] => index.php
            [SEO_description] => 
            [type] => SD
            [image_name] => 
            [image_description] => 
            [alt] => 
            [URL] => fr/accueil/
        )
)`

# pilot::list_all_language()
Retourne un tableau contenant les langues installées dans la partie front-end du site.

exemple : 

`print_r(pilot::list_all_language());`

retournera

`Array
(
    [fr] => Français
    [en] => Anglais
    [de] => Allemand
)
		`
		
	
# pilot::get_page(id | slug)

Retourne le même tableau que la fonction pilot::get_pages() mais n'accepte qu'un seul argument et ne renvoie qu'un seul résultat. 

En général elle est utilisée pour appeler toutes les informations de la page courante.

# pilot::get_theme_options(option)

retourne la valeur d'une option de thème en fonction de son nom. 

exemple 

`echo pilot::get_theme_options("hello")`;

va retourner

`World !`

# pilot::get_image(src)
retourne un tableau avec toutes les qualités de l'image disponibles pour une source données.

# pilot::get_meta()
retourne les meta personnalisées du CMS.

# pilot::get_analytics()
retourne le script d'intégration de l'analytics natif de Pilot

`<script id='geronimo_analytics' src='CMS/Analytics/analytics.js'></script>`

# pilot::get_menu()
Retourne un tableau contenant le menu

# pilot::get_footer()
retourne un tableau contenant le pied de page du site.

# pilot::get_title(id)
retourne le nom de la page actuelle ou d'un id sélectionné

# pilot::get_content(id)
retourne le texte de la page actuelle ou d'un id sélectionné

# pilot::get_description(id)
retourne la description de la page actuelle ou d'un id sélectionné

# pilot::get_author(id)
retourne l'auteur de la page actuelle ou d'un id sélectionné

# pilot::get_date_time(id)
Retourne le time de la page actuelle ou d'un id sélectionné

# Variables globales
## pilot::_the_page

retourne un tableau contenant toutes les informations de la page actuelle
