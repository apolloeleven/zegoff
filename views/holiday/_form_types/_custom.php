<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/7/19
 * Time: 6:15 PM
 */

use app\models\Holiday;
use trntv\yii\datetime\DateTimeWidget;

?>

<?php echo $this->render('@app/views/holiday/_form_types/_business', ['form' => $form, 'model' => $model, 'disabled' => $disabled ? $disabled : false]) ?>
