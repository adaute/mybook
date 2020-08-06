<?php

namespace TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use CoreBundle\Entity\Common\Indentificator;
use CoreBundle\Entity\Common\TimeLine;
use CoreBundle\Validator\Constraints as UserAssert;

use CoreBundle\Entity\Common\Interfaces\TimeLineInterface;
use CoreBundle\Entity\Common\Interfaces\IndentificatorInterface;

/**
 * @ORM\Table(name="answer")})
 * @ORM\Entity(repositoryClass="TicketBundle\Repository\AnswerRepository")
 */
class Answer implements TimeLineInterface, IndentificatorInterface
{
    use Indentificator;

    use TimeLine;

    /**
     * @ORM\Column(type="string",length=1000)
     * @Assert\NotBlank()
     * @Assert\Length(min = 5)
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="TicketBundle\Entity\Ticket")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id", onDelete="cascade")
     */
    private $ticket;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade")
     */
    private $author;

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param mixed $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * @return mixed
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param mixed $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

}
