<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 24/04/2019
 * Time: 00:17
 */

namespace App\Traits;


use App\Message;
use App\User;
use Exception;

trait Messaging
{
    use Emailing;
    /**
     * Method sends a message to a users virtual inbox
     *
     * @param User $to The user receiving the message
     * @param string $subject The messages subject line
     * @param string $message The messages content
     * @return Message A newly created message object
     */
    public function sendMessage(User $to, $subject, $message)
    {
        return Message::create([
            'userID' => $to->id,
            'subject' => $subject,
            'message' => $message,
            'read' => 0
        ]);
    }

    /**
     * Set a message as read
     *
     * @param Message $message The message to be set as read
     * @return bool Status of the read message request. True on success
     */
    public function readMessage(Message $message)
    {
        try{
            $message->read = 1;
            return $message->save();
        }
        catch (Exception $exception)
        {
            return false;
        }

    }

    /**
     * Delete a message from the messaging system
     *
     * @param Message $message The message to be deleted
     * @return bool Status of the delete message request. True on success
     */
    public function deleteMessage(Message $message)
    {
        try
        {
            return $message->delete();
        }
        catch (Exception $exception)
        {
            return false;
        }
    }
}