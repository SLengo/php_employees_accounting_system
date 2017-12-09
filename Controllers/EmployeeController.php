<?php
/**
 * Created by PhpStorm.
 * User: slack
 * Date: 08.12.2017
 * Time: 2:44:PM
 */

class EmployeeController extends ActionController
{
    public function _init()
    {
        $this->_layout->LocalMenu->add('<a href="/Employee/Add">Добавить сотрудника</a>');
        $this->_layout->LocalMenu->add('<a href="/Employee/History">История изменений</a>');
    }

    public function IndexAction()
    {
        $arrWithAllEmployees = $this->_db->query('SELECT * FROM `employees`')->fetchAll(PDO::FETCH_ASSOC);
        $this->_view->employees = $arrWithAllEmployees;
    }


    public function setHistory($actionType, $arrWithParams){
        $json_param = [
            'action' => '',
            'params' => [],
            'params_old' => [],
        ];
        switch ($actionType){
            case "add":{

                $json_param['action'] = $actionType;
                $arrWithParams['birthday_date'] = strtotime($arrWithParams['birthday_date']);
                $json_param['params'] = $arrWithParams['emp_params'];

                $stm = $this->_db->prepare("INSERT INTO employees_history(
                                                      user_id,
                                                      date,
                                                      json_param)
                                                      VALUES (?,?,?)
                                           ");
                $stm->execute([
                    $arrWithParams['user_id'],
                    strtotime(date('Y-m-d H:i:s')),
                    json_encode($json_param, JSON_UNESCAPED_UNICODE),
                ]);
                break;
            }
            case "edit":{

                $emp = $this->_db->query('SELECT name, surname, patronymic, position, sex, pass, phone, email, birthday_date FROM employees WHERE id = ' . $arrWithParams['user_id'])->fetchAll(PDO::FETCH_ASSOC);

                $json_param['action'] = $actionType;
                $arrWithParams['emp_params']['birthday_date'] = strtotime($arrWithParams['emp_params']['birthday_date']);
                $json_param['params'] = $arrWithParams['emp_params'];
                $json_param['params_old'] = $emp[0];

                $stm = $this->_db->prepare("INSERT INTO employees_history(
                                                      user_id,
                                                      date,
                                                      json_param)
                                                      VALUES (?,?,?)
                                           ");
                $stm->execute([
                    $arrWithParams['user_id'],
                    strtotime(date('Y-m-d H:i:s')),
                    json_encode($json_param, JSON_UNESCAPED_UNICODE),
                ]);
                break;
            }
            case "delete":{
                $json_param['action'] = $actionType;
                $json_param['params'] = [];

                $stm = $this->_db->prepare("INSERT INTO employees_history(
                                                      user_id,
                                                      date,
                                                      json_param)
                                                      VALUES (?,?,?)
                                           ");
                $stm->execute([
                    $arrWithParams['user_id'],
                    strtotime(date('Y-m-d H:i:s')),
                    json_encode($json_param, JSON_UNESCAPED_UNICODE),
                ]);
                break;
            }
        }
    }

    public function HistoryAction(){
        $history = $this->_db->query('SELECT * FROM employees_history JOIN employees ON employees_history.user_id=employees.id')->fetchAll(PDO::FETCH_ASSOC);
        $resArr = [
            'header' => [],
            'body' => [],
        ];
        foreach ($history as $item){
            $json = json_decode($item['json_param']);
            switch ($json->{'action'}){
                case 'add':{
                    $resArr['header'][] = '<span class="glyphicon glyphicon-plus"></span><strong>' . date("Y-m-d H:i:s", $item['date']) . '</strong> Добавлен сотрудник №' . $item['user_id'] . ' ' . $item['name'] . ' ' . $item['surname'] . ' ' . $item['patronymic'];
                    $resArr['body'][] = 'Имя: ' . $json->{'params'}->{'name'} . '<br>' .
                                        'Фамилия: ' . $json->{'params'}->{'surname'} . '<br>' .
                                        'Отчество: ' . $json->{'params'}->{'patronymic'} . '<br>' .
                                        'Должность: ' . $json->{'params'}->{'position'} . '<br>' .
                                        'Пол: ' . $json->{'params'}->{'sex'} . '<br>' .
                                        'Паспорт: ' . $json->{'params'}->{'pass'} . '<br>' .
                                        'Телевфон: ' . $json->{'params'}->{'phone'} . '<br>' .
                                        'Email: ' . $json->{'params'}->{'email'} . '<br>' .
                                        'Дата рождения: ' . date("Y/m/d", $json->{'params'}->{'birthday_date'});
                    break;
                }
                case 'edit':{
                    $resArr['header'][] = '<span class="glyphicon glyphicon-edit"></span> <strong>' . date("Y-m-d H:i:s", $item['date']) . '</strong> Редактирован сотрудник №' . $item['user_id'] . ' ' . $item['name'] . ' ' . $item['surname'] . ' ' . $item['patronymic'];
                    $strWithEdits = "";
                    if($json->{'params'}->{'name'} != $json->{'params_old'}->{'name'}){
                        $strWithEdits .= 'Отредактировано поле <strong>ИМЯ</strong>: ' . $json->{'params'}->{'name'} . ' (новое), ' .  $json->{'params_old'}->{'name'} . ' (старое)<br>';
                    }
                    if($json->{'params'}->{'surname'} != $json->{'params_old'}->{'surname'}){
                        $strWithEdits .= 'Отредактировано поле <strong>ФАМИЛИЯ</strong>: ' . $json->{'params'}->{'surname'} . ' (новое), ' .  $json->{'params_old'}->{'surname'} . ' (старое)<br>';
                    }
                    if($json->{'params'}->{'patronymic'} != $json->{'params_old'}->{'patronymic'}){
                        $strWithEdits .= 'Отредактировано поле <strong>ОТЧЕСТВО</strong>: ' . $json->{'params'}->{'patronymic'} . ' (новое), ' .  $json->{'params_old'}->{'patronymic'} . ' (старое)<br>';
                    }
                    if($json->{'params'}->{'sex'} != $json->{'params_old'}->{'sex'}){
                        $strWithEdits .= 'Отредактировано поле <strong>ПОЛ</strong>: ' . $json->{'params'}->{'sex'} . ' (новое), ' .  $json->{'params_old'}->{'sex'} . ' (старое)<br>';
                    }
                    if($json->{'params'}->{'pass'} != $json->{'params_old'}->{'pass'}){
                        $strWithEdits .= 'Отредактировано поле <strong>ПАСПОРТ</strong>: ' . $json->{'params'}->{'pass'} . ' (новое), ' .  $json->{'params_old'}->{'pass'} . ' (старое)<br>';
                    }
                    if($json->{'params'}->{'phone'} != $json->{'params_old'}->{'phone'}){
                        $strWithEdits .= 'Отредактировано поле <strong>ТЕЛЕФОН</strong>: ' . $json->{'params'}->{'phone'} . ' (новое), ' .  $json->{'params_old'}->{'phone'} . ' (старое)<br>';
                    }
                    if($json->{'params'}->{'email'} != $json->{'params_old'}->{'email'}){
                        $strWithEdits .= 'Отредактировано поле <strong>EMAIL</strong>: ' . $json->{'params'}->{'email'} . ' (новое), ' .  $json->{'params_old'}->{'name'} . ' (старое)<br>';
                    }
                    if($json->{'params'}->{'birthday_date'} != $json->{'params_old'}->{'birthday_date'}){
                        $strWithEdits .= 'Отредактировано поле <strong>ДАТА РОЖДЕНИЯ</strong>: ' . date("Y/m/d", $json->{'params'}->{'birthday_date'}) . ' (новое), ' .  date("Y/m/d", $json->{'params_old'}->{'birthday_date'}) . ' (старое)<br>';
                    }
                    $resArr['body'][] = $strWithEdits;
                    break;
                }
                case 'delete':{
                    $resArr['header'][] = '<span class="glyphicon glyphicon-remove"></span> <strong>' . date("Y-m-d H:i:s", $item['date']) . '</strong> Удален сотрудник №' . $item['user_id'] . ' ' . $item['name'] . ' ' . $item['surname'] . ' ' . $item['patronymic'];
                    $resArr['body'][] = "";
                    break;
                }
            }
        }
         $this->_view->history = $resArr;
    }

    public function validatePost($arrayPost,$actionWithTable){
        $resArr = [
            'message' => "",
            'formvalidationerrs' => [],
        ];
        $formvalidationerrs = [];
        if (isset($arrayPost['add_emp_btn'])) { //если кликнули на кнопку submit

            // проверим есть ли такие паспортные данные в базе
            $passCheck = $this->_db->query('SELECT * FROM employees WHERE pass="' . $arrayPost['pass'] . '"')->fetchAll(PDO::FETCH_ASSOC);
            if(count($passCheck)) {
                if ($actionWithTable == 'edit' && ($passCheck[0]['id'] != $arrayPost['emp_id'])) {
                    $formvalidationerrs[] = "Нельзя поменять паспортные данные! Они записаны у другого сорудника!";
                } else if ($actionWithTable == "add") {
                    $formvalidationerrs[] = "Человек с такими паспортными данными уже есть в базе!";
                }
            }

            //валидируем форму
            if(strlen($arrayPost['name']) > 255){
                $formvalidationerrs[] = "Имя должно быть короче 255 символов!";
            }
            if(strlen($arrayPost['surname']) > 255){
                $formvalidationerrs[] = "Фамилия должно быть короче 255 символов!";
            }
            if(strlen($arrayPost['patronymic']) > 255){
                $formvalidationerrs[] = "Отчество должно быть короче 255 символов!";
            }
            if(strlen($arrayPost['position']) > 255){
                $formvalidationerrs[] = "Должность должна быть короче 255 символов!";
            }
            if(!preg_match('/^[0-9]{4}[ ][0-9]{6}$/',$arrayPost['pass'],$match)){
                $formvalidationerrs[] = "Введите правильно серию и номер паспорта!";
            }
            if($arrayPost['sex'] != "Не указан" && $arrayPost['sex'] != "Мужской" && $arrayPost['sex'] != "Женский"){
                $formvalidationerrs[] = "Пол указан неверно!";
            }
            if(!preg_match('/^[+7 (]{4}[0-9]{3}[) ]{2}[0-9]{2}-[0-9]{2}-[0-9]{3}$/',$arrayPost['phone'],$match)){
                $formvalidationerrs[] = "Введите правильно номер телефона!";
            }
            if(!preg_match('/^[\w\.-]+@[\w\.-]+$/',$arrayPost['email'],$match)){
                $formvalidationerrs[] = "Введите правильно email!";
            }

            if(!count($formvalidationerrs)){

                //переведем дату в unix timestamp
                $date = strtotime($arrayPost['birthday_date']);

                if($actionWithTable == "add") {

                    $stm = $this->_db->prepare("INSERT INTO employees(
                                                      name,
                                                      surname,
                                                      patronymic,
                                                      position,
                                                      sex,
                                                      pass,
                                                      phone,
                                                      email,
                                                      birthday_date)
                                                      VALUES (?,?,?,?,?,?,?,?,?)
                                           ");
                    $stm->execute([
                        $arrayPost['name'],
                        $arrayPost['surname'],
                        $arrayPost['patronymic'],
                        $arrayPost['position'],
                        $arrayPost['sex'],
                        $arrayPost['pass'],
                        $arrayPost['phone'],
                        $arrayPost['email'],
                        $date,
                    ]);

                    $arrForSetHistory = [
                        'user_id' => $this->_db->lastInsertId(),
                        'emp_params' => $arrayPost,
                    ];
                    $this->setHistory($actionWithTable,$arrForSetHistory);

                    $resArr['message'] = "Запись добавлена!";
                }
                else if ($actionWithTable == "edit"){

                    $arrForSetHistory = [
                        'user_id' => $arrayPost['emp_id'],
                        'emp_params' => $arrayPost,
                    ];
                    $this->setHistory('edit',$arrForSetHistory);

                    $stm = $this->_db->prepare("UPDATE employees SET
                                                      name = ?,
                                                      surname = ?,
                                                      patronymic = ?,
                                                      position = ?,
                                                      sex = ?,
                                                      pass = ?,
                                                      phone = ?,
                                                      email = ?,
                                                      birthday_date = ?
                                                      WHERE id = ?"
                                           );
                    $stm->execute([
                        $arrayPost['name'],
                        $arrayPost['surname'],
                        $arrayPost['patronymic'],
                        $arrayPost['position'],
                        $arrayPost['sex'],
                        $arrayPost['pass'],
                        $arrayPost['phone'],
                        $arrayPost['email'],
                        $date,
                        $arrayPost['emp_id'],
                    ]);
                    $resArr['message'] = "Запись отредактирована!";
                }
            }
        }
        $resArr['formvalidationerrs'] = $formvalidationerrs;
        return $resArr;
    }

    public function EditAction(){
        //если в GET запросе к этой странице не указан id пользователя (именно id, проверяется регулярным выражением), то редиректим на главную страницу системы учета
        if(!isset($_GET['emp_id']) && !preg_match('/^[0-9]{1,10}$/',$_GET['emp_id'],$match)) {
            header("Location:/Employee/");
            exit();
        }
        else{
            //если id есть и он корректный (по регулярному выражению, то берем сотрудника их базы)
            $emp = $this->_db->query('SELECT * FROM employees WHERE id = ' . $_GET['emp_id'])->fetchAll(PDO::FETCH_ASSOC);

            if(!count($emp)){// если сюда решили попасть не из таблицы на странице /Employee/, то, вероятно, по такому Id нет сотрудника в базу, если это так, то редиректим на главную страницу системы учета
                header("Location:/Employee/");
                exit();
            }
            $this->_view->employee = array_pop( $emp ); // по одному id возвратится гарантированно один сотрудник, поэтому просто берем из массива верхний объект, чтобы не обращаться к сотруднику как к массиву

            if(isset($_POST['add_emp_btn'])){ // если была нажата кнопка на форме редактирования сотрудника

                $_POST['emp_id'] = $_GET['emp_id']; // уберем в POST id сотрудника, понадобится для update
                $resArr = $this->validatePost($_POST,"edit");

                // вызовем валидацию данных формы
                if($resArr['message'] != ""){ // если пришло сообщение после валидации
                    $this->_view->message = $resArr['message']; // добавим его в поле view
                }

                if(!count($resArr['formvalidationerrs'])){ // если ошибок нет, то отправим обновленого сотрудника на форму редактирования

                    $emp = $this->_db->query('SELECT * FROM employees WHERE id = ' . $_GET['emp_id'])->fetchAll(PDO::FETCH_ASSOC);
                    $this->_view->employee = array_pop( $emp );

                }
                $this->_view->formvalidationerrs = $resArr['formvalidationerrs']; // отправим на view массив с сообщениями об ошибках валидации
            }
        }
    }

    public function DeleteAction(){
        if(isset($_POST['result_emp']) && preg_match('/^[0-9]{1,10}$/',$_POST['result_emp'],$match)){ //если в этот метод был прислан id пользователя и он именно id, а не что-то другое

            $stm = $this->_db->prepare('UPDATE employees SET is_deleted = 1 WHERE id = ' . $_POST['result_emp']); // ставим флаг удаления для конкретного сотрудника
            $stm->execute();

            $arrForHistory = [
                'user_id' => $_POST['result_emp'],
            ];
            $this->setHistory("delete",$arrForHistory);
        }
    }

    public function AddAction()
    {
        $resArr = [];
        if (isset($_POST['add_emp_btn'])) { // если была нажата кнопка на форме добавления

            $resArr = $this->validatePost($_POST,"add"); // вызовем валидацию полей формы

            if($resArr['message'] != ""){ // если пришло сообщение от валидации, добавим его в поле view
                $this->_view->message = $resArr['message'];
            }

            $this->_view->formvalidationerrs = $resArr['formvalidationerrs']; // добавим массив с сообщениями об ошибках валидации на view
        }
    }
}