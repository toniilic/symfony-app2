<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints as CaptchaAssert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

/*    /**
     * @CaptchaAssert\ValidCaptcha(
     *      message = "CAPTCHA validation failed, try again."
     * )
     */
/*    protected $captchaCode;*/

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bonus", mappedBy="author")
     */
    private $bonuses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Casino", mappedBy="author")
     */
    private $casinos;

    public function __construct()
    {
        parent::__construct();
        $this->phoneNumbers = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->taskApplications = new ArrayCollection();
        $this->taskApplication = new ArrayCollection();
        $this->bonuses = new ArrayCollection();
        $this->casinos = new ArrayCollection();
    }


    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Bonus[]
     */
    public function getBonuses(): Collection
    {
        return $this->bonuses;
    }

    public function addBonus(Bonus $bonus): self
    {
        if (!$this->bonuses->contains($bonus)) {
            $this->bonuses[] = $bonus;
            $bonus->setAuthor($this);
        }

        return $this;
    }

    public function removeBonus(Bonus $bonus): self
    {
        if ($this->bonuses->contains($bonus)) {
            $this->bonuses->removeElement($bonus);
            // set the owning side to null (unless already changed)
            if ($bonus->getAuthor() === $this) {
                $bonus->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Casino[]
     */
    public function getCasinos(): Collection
    {
        return $this->casinos;
    }

    public function addCasino(Casino $casino): self
    {
        if (!$this->casinos->contains($casino)) {
            $this->casinos[] = $casino;
            $casino->setAuthor($this);
        }

        return $this;
    }

    public function removeCasino(Casino $casino): self
    {
        if ($this->casinos->contains($casino)) {
            $this->casinos->removeElement($casino);
            // set the owning side to null (unless already changed)
            if ($casino->getAuthor() === $this) {
                $casino->setAuthor(null);
            }
        }

        return $this;
    }
}