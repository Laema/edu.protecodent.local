<?php
namespace Ajax;
use \Ajax\Response;
use Bitrix\Main;
class User
{
    public static function mailingUnsubscribe ()
    {
        $response = new Response();
        try {
            if (!\CModule::IncludeModule("subscribe")) throw new Exception('Не подключен модуль iblock');
            $request = Main\Application::getInstance()->getContext()->getRequest();
            $id = $request->getPost('ID') ? : $_GET['ID'];

            if ($id) {
                $res = \CSubscription::Delete($id);
                return $response->shapeOk([], 'Подписка успешно удалена');
            }
        } catch (Exception $e) {
            return $response->shapeError([], $e);
        }
    }

    public static function sendInvite ()
    {
        $response = new Response();
        try {
            global $USER;
            $request = Main\Application::getInstance()->getContext()->getRequest();
            $url = $request->getPost('EVENT_URL').'?INVITE='.$USER->GetID();
            $send = Main\Mail\Event::send(array(
                "EVENT_NAME" => "INVITE_USER",
                "LID" => "s1",
                "C_FIELDS" => array(
                    "AUTHOR_NAME" => $USER->GetFullName(),
                    "EMAIL_FROM" => $USER->GetEmail(),
                    "EMAIL_TO" => $request->getPost('EMAIL'),
                    "URL" => $url
                ),
            ));
            if ($send->getId()) {
                return $response->shapeOk([], 'Приглашение успешно отправлено');
            }
        } catch (Exception $e) {
            return $response->shapeError([], $e);
        }
    }
}
