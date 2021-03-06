<?php
namespace maxlapko\components;

use Yii;
/**
 * Controller for not force process
 * 
 * @author mlapko <maxlapko@gmail.com> 
 * 
 * //config main.php
 * //....
 * 
 * .htaccess ->
 *   # if a directory or a file exists, use it directly
 *   RewriteCond %{REQUEST_FILENAME} !-d
 *   RewriteCond %{REQUEST_FILENAME} !-f
 *   # files/img/{namespace}/{preset}/{subDir}/{filename}
 *   RewriteRule ^files/img/([^/]+)/([^/]+)/([^/]+)/([^/]+)$ image_processor/resize/n/$1/p/$2/d/$3/f/$4 [L]
 * 
 * index.php -> top
 *   if (isset($_SERVER['REDIRECT_URL']) && preg_match('/image_processor\/resize/i', $_SERVER['REDIRECT_URL'])) {
 *       $_SERVER['REQUEST_URI'] = $_SERVER['REDIRECT_URL'];
 *   } 
 *   
 */
class ImageProcessorController extends \yii\web\Controller
{
    /**
     * Resize Image
     * @param string $n namespane
     * @param string $p preset
     * @param string $d sub directory
     * @param string $f file
     * @param boolean $output
     */
    public function actionResize($n, $p, $d, $f)
    {
        $imageProcessor = Yii::$app->get('image');
        $originalFile = $imageProcessor->getImagePath($f, 'orig', $n);
        
        if (file_exists($originalFile)) {
            session_write_close();
            $params = ['save' => ['namespace' => $n]]; 
            return $imageProcessor->process($originalFile, $p, $params)->show(); // save and show
        }
    }
}