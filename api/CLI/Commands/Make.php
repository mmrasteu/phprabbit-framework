<?php 

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;
use Rabbit\Utils\FileContent;
use Rabbit\Helpers\FormatCase;

class Make extends Command {

  public function handleMakeCommand($type, $name, $arrayOptions){
    
    if($name == '') {
      $this->argumentException("Ha ocurrido un error al ejecutar el comando `make`. Es necesario proporcionar un nombre");
    }

    $model = (in_array('--model', $arrayOptions)) ? true : false;
    $makeMigration = (in_array('--no-migration', $arrayOptions)) ? false : true;

    switch($type){
        case 'controller':
            $this->makeController($name, $model, $makeMigration);
            break;
        case 'model':
            $this->makeModel($name, false, $makeMigration);
            break;
        case 'validator':
            $this->makeValidator($name);
            break;
        case 'migration':
            $this->makeMigration($name, false);
            break;
        case 'middleware':
            $this->makeMiddleware($name);
            break;
        default:
            rabbit_debug("Ha ocurrido un error al ejecutar el comando `make`", true);
            $this->argumentException("Ha ocurrido un error al ejecutar el comando `make`");
            break;
    }
  }

  private function makeController($name, $model=false, $makeMigration=true) {
      // Paso 1: Limpiar el nombre del controlador
      $controllerName = ucfirst($name);
      $controllerClassName = $controllerName . 'Controller';
      $modelClassName = $controllerName . 'Model';  // Nombre del modelo
      
      // Paso 2: Crear el contenido del archivo del controlador
      $fc = new FileContent($controllerClassName, './api/Controllers/', 'php');

      $fc->setContentLine("<?php\n");
      $fc->setContentLine("namespace Rabbit\Controllers;\n");
      $fc->setContentLine("use Rabbit\Core\BaseController;");
      if ($model) {
          $fc->setContentLine("use Rabbit\Models\\{$modelClassName};");  // Importar el modelo
      }
      $fc->setContentLine("use Rabbit\Validators\\{$controllerName}Validator;");
      $fc->setContentLine("use Rabbit\Exceptions\BaseException;");
      $fc->setContentLine("use Rabbit\Exceptions\ValidationException;");
      $fc->setContentLine("use Rabbit\Exceptions\DatabaseException;");
      $fc->setContentLine("use Rabbit\Exceptions\ExceptionHandler;\n");
      $fc->setContentLine("class $controllerClassName extends BaseController {\n");

      // Métodos get, set, update, delete
      $this->generateControllerMethod($fc, 'get', $controllerName, $model);
      $this->generateControllerMethod($fc, 'getAll', $controllerName, $model);
      $this->generateControllerMethod($fc, 'set', $controllerName, $model);
      $this->generateControllerMethod($fc, 'update', $controllerName, $model);
      $this->generateControllerMethod($fc, 'delete', $controllerName, $model);

      $fc->setContentLine("}\n");

      // Paso 3: Crear el archivo del controlador
      $fc->create();

      // Si $model es true, también creamos el modelo
      if ($model) {
          $this->makeModel($controllerName, true, $makeMigration);
      }

      // Paso 4: Crear el validador
      $this->makeValidator($name, true);

      rabbit_debug("Controlador '$controllerClassName' creado satisfactoriamente.", true);
    }
  
  // Función auxiliar para generar el código de los métodos get, set, update, delete
  private function generateControllerMethod(FileContent $fc, $action, $controllerName, $model=false) {
    if(!$model) {
      $methodName = "{$action}{$controllerName}";

      $fc->setContentLine("public function $methodName() {", 1);
      $fc->setContentLine("try {", 2);
      $fc->setContentLine("\$this->validate(new {$controllerName}Validator(\$this->request, \$this->response));\n", 3);
      $fc->setContentLine("\$data = [];\n", 3);
      $fc->setContentLine("\$this->response->withStatus200(\$data);", 3);
      $fc->setContentLine("} catch (ValidationException \$e) {",2);
      $fc->setContentLine("ExceptionHandler::handle(\$e);",3);
      $fc->setContentLine("\$this->response->withStatus400(\$e->getMessage());",3);
      $fc->setContentLine("} catch (DatabaseException \$e) {",2);
      $fc->setContentLine("ExceptionHandler::handle(\$e);",3);
      $fc->setContentLine("\$this->response->withStatus500(\$e->getMessage());",3);
      $fc->setContentLine("} catch (BaseException \$e) {",2);
      $fc->setContentLine("ExceptionHandler::handle(\$e);",3);
      $fc->setContentLine("\$this->response->withStatus500(\$e->getMessage());",3);
      $fc->setContentLine("}",2);
      $fc->setContentLine("}\n",1); 

    } else {
      $methodName = "{$action}{$controllerName}";
      $modelClassName = $controllerName.'Model';
      $arguments = [];
      if($action != 'getAll' && $action != 'set') {$arguments[]="\$id";}
      if($action == 'set' || $action == 'update') {$arguments[]="\$data";} else {$data="";}
      $args = implode(",", $arguments);

      $fc->setContentLine("public function $methodName($args) {", 1);
      $fc->setContentLine("try {", 2);
      $fc->setContentLine("\$this->validate(new {$controllerName}Validator(\$this->request, \$this->response));\n", 3);   
      
      if ($action == 'get') {
        $fc->setContentLine("\$data = $modelClassName::get{$controllerName}ByIndex(\$id);\n", 3);
      }
      elseif($action == 'getAll'){
        $fc->setContentLine("\$data = $modelClassName::getAll{$controllerName}();\n", 3);
      }
      elseif($action == 'set'){
        $fc->setContentLine("\$data = $modelClassName::create{$controllerName}(\$data);\n", 3);
      }
      elseif($action == 'update'){
        $fc->setContentLine("\$data = $modelClassName::update{$controllerName}(\$id, \$data);\n", 3);
      }
      elseif($action == 'delete'){
        $fc->setContentLine("\$data = $modelClassName::delete{$controllerName}(\$id);\n", 3);
      }
      
      $fc->setContentLine("\$this->response->withStatus200(\$data);", 3);
      $fc->setContentLine("} catch (ValidationException \$e) {",2);
      $fc->setContentLine("ExceptionHandler::handle(\$e);",3);
      $fc->setContentLine("\$this->response->withStatus400(\$e->getMessage());",3);
      $fc->setContentLine("} catch (DatabaseException \$e) {",2);
      $fc->setContentLine("ExceptionHandler::handle(\$e);",3);
      $fc->setContentLine("\$this->response->withStatus500(\$e->getMessage());",3);
      $fc->setContentLine("} catch (BaseException \$e) {",2);
      $fc->setContentLine("ExceptionHandler::handle(\$e);",3);
      $fc->setContentLine("\$this->response->withStatus500(\$e->getMessage());",3);
      $fc->setContentLine("}",2);
      $fc->setContentLine("}\n",1);
    }

    return true;
  }

  private function makeValidator($name, $callByMakeController=false) {
    // Paso 1: Quitar la palabra "Controller", "Controler" o "Controlador" del nombre
    $name = str_ireplace(['Validator', 'validator'], '', $name);
      
    // Paso 2: Concatenar "Validator"
    $validatorName = $name . 'Validator';

    // Crear el contenido de la clase
    $fc = new FileContent($validatorName, './api/Validators/', 'php');

    $fc->setContentLine("<?php\n");
    $fc->setContentLine("namespace Rabbit\Validators;\n");
    $fc->setContentLine("use Rabbit\Core\RequestValidator;");
    $fc->setContentLine("class $validatorName extends RequestValidator {\n");
    $fc->setContentLine("protected \$accepts = [];\n", 1);
    $fc->setContentLine("protected \$rules = [];", 1);
    $fc->setContentLine("}");

    // Paso 3: Crear el archivo en la ruta ./api/Controllers
    $fc->create();

    if(!$callByMakeController) {
      echo "Validador creado correctamente\n";
    }
    rabbit_debug("Validador creado correctamente");
  }

  private function makeModel($name, $callByMakeController=false, $makeMigration=true) {
    // Paso 1: Generar el nombre del modelo y la migración
    $modelName = ucfirst($name);
    $modelClassName = $modelName . 'Model';
    
    $formatedName = FormatCase::convertTextToSnakeCase($modelName);
    $tableName = strtolower($formatedName);  // El nombre de la tabla será en minúsculas

    // Paso 2: Crear el archivo del modelo
    $fc = new FileContent($modelClassName, './api/Models/', 'php');

    $fc->setContentLine("<?php\n");
    $fc->setContentLine("namespace Rabbit\Models;\n");
    $fc->setContentLine("use Illuminate\Database\Eloquent\Model;\n");
    $fc->setContentLine("class $modelClassName extends Model {");
    $fc->setContentLine("protected \$table = '$tableName';", 1);
    $fc->setContentLine("protected \$primaryKey = 'id';", 1);
    $fc->setContentLine("public \$timestamps = true;\n", 1);

    // Métodos CRUD
    $fc->setContentLine("protected \$fillable = ['name'];\n", 1);

    // Método getAllUsers
    $fc->setContentLine("public static function getAll{$modelName}() {",1);
    $fc->setContentLine("return self::all();",2);
    $fc->setContentLine("}\n",1);

    // Método getUserById
    $fc->setContentLine("public static function get{$modelName}ById(\$id) {",1);
    $fc->setContentLine("return self::find(\$id);",2);
    $fc->setContentLine("}\n",1);

    // Método createUser
    $fc->setContentLine("public static function create{$modelName}(\$data) {",1);
    $fc->setContentLine("return self::create(\$data);",2);
    $fc->setContentLine("}\n",1);

    // Método updateUser
    $fc->setContentLine("public static function update{$modelName}(\$id, \$data) {",1);
    $fc->setContentLine("\$user = self::find(\$id);",2);
    $fc->setContentLine("if (\$user) {",2);
    $fc->setContentLine("\$user->update(\$data);",3);
    $fc->setContentLine("return \$user;",3);
    $fc->setContentLine("}",2);
    $fc->setContentLine("return null;",2);
    $fc->setContentLine("}\n",1);

    // Método deleteUser
    $fc->setContentLine("public static function delete{$modelName}(\$id) {",1);
    $fc->setContentLine("\$user = self::find(\$id);",2);
    $fc->setContentLine("if (\$user) {",2);
    $fc->setContentLine("\$user->delete();",3);
    $fc->setContentLine("return true;",3);
    $fc->setContentLine("}",2);
    $fc->setContentLine("return false;",2);
    $fc->setContentLine("}\n",1);

    $fc->setContentLine("}");

    // Crear el archivo del modelo
    $fc->create();

    if(!$callByMakeController) {
      echo "Modelo '$modelClassName' creado satisfactoriamente\n";
    }
    rabbit_debug("Modelo '$modelClassName' creado satisfactoriamente");

    if ($makeMigration) {
        // Paso 3: Crear el archivo de la migración. 
        // Recibe el parametro $name igual que el modelo porque el metodo makeMigration tiene su propia logica de generar nombre a partir del nombre base que se pasa por comando.
        $this->makeMigration($name, $callByMakeController, true);
      }
  }
  

  private function makeMigration($name, $callByMakeController, $callByMakeModel=false) {
    $name = ucfirst($name);
    $formatedName = FormatCase::convertTextToSnakeCase($name);
    $migrationName = 'create_' . $formatedName . '_table';
    $tableName = strtolower($formatedName);  // El nombre de la tabla será en minúsculas
  
    $fc = new FileContent(date('Y_m_d_His') . '_' . $migrationName, './migrations/', 'php');

    $fc->setContentLine("<?php\n");
    $fc->setContentLine("use Illuminate\Database\Capsule\Manager as Capsule;");
    $fc->setContentLine("use Illuminate\Support\Facades\DB;\n");
    $fc->setContentLine("class $migrationName {");
    $fc->setContentLine("public function up() {", 1);
    $fc->setContentLine("Capsule::schema()->create('$tableName', function(\$table) {", 2);
    $fc->setContentLine("\$table->increments('id');", 3);
    $fc->setContentLine("\$table->string('name');", 3);
    $fc->setContentLine("// Agrega los campos que necesites", 3);
    $fc->setContentLine("\$table->timestamps();", 3);
    $fc->setContentLine("});", 2);
    $fc->setContentLine("}\n", 1);
    $fc->setContentLine("public function down() {", 1);
    $fc->setContentLine("Capsule::schema()->drop('$tableName');", 2);
    $fc->setContentLine("}", 1);
    $fc->setContentLine("}");

    // Crear el archivo de migración
    $fc->create();

    if(!$callByMakeController && !$callByMakeModel) {
      echo "Migración '$migrationName' creada satisfactoriamente\n";
      echo "Recuerda añadir los campos que necesites a la migración antes de ejectuarla con `php rabbit migrate`\n";
    }
    rabbit_debug("Migración '$migrationName' creada satisfactoriamente");
  }

  private function makeMiddleware($name) {
    $middlewareName = ucfirst($name);
    $middlewareName = str_ireplace(['middleware', 'Middleware'], '', $middlewareName);
    $middlewareName .= 'Middleware';

    $fc = new FileContent($middlewareName, './api/Middleware/', 'php');

    $fc->setContentLine("<?php\n");
    $fc->setContentLine("namespace Rabbit\Middlewares;\n");
    $fc->setContentLine("class $migrationName {");
    $fc->setContentLine("public function __construct() {\n", 1);
    $fc->setContentLine("}\n", 1);
    $fc->setContentLine("public function handle() {\n", 1);
    $fc->setContentLine("}\n", 1);
    $fc->setContentLine("}");

    // Crear el archivo de migración
    $fc->create();

    if(!$callByMakeController && !$callByMakeModel) {
      echo "Migración '$migrationName' creada satisfactoriamente\n";
      echo "Recuerda añadir los campos que necesites a la migración antes de ejectuarla con `php rabbit migrate`\n";
    }
    rabbit_debug("Migración '$migrationName' creada satisfactoriamente");
  }

}
