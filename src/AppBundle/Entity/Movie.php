<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\MovieRepository")
 */
class Movie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="imdbId", type="string", length=20)
     */
    private $imdbId;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var integer
     *
     * @ORM\Column(name="annee", type="integer", precision=4)
     */
    private $annee;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="decimal", precision=2, scale=1)
     */
    private $note;

    /**
     * @var integer
     *
     * @ORM\Column(name="votes", type="integer", precision=11)
     */
    private $votes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sortie", type="date", nullable=true)
     */
    private $sortie;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="realisateurs", type="string", length=255)
     */
    private $realisateurs;

    /**
     * @var string
     *
     * @ORM\Column(name="scenaristes", type="string", length=255, nullable=true)
     */
    private $scenaristes;

    /**
     * @var string
     *
     * @ORM\Column(name="acteurs", type="string", length=255, nullable=true)
     */
    private $acteurs;

    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="text", nullable=true)
     */
    private $resume;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="afficheUrl", type="text")
     */
    private $afficheUrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModification", type="datetime")
     */
    private $dateModification;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set imdbId
     *
     * @param string $imdbId
     * @return Movie
     */
    public function setImdbId($imdbId)
    {
        $this->imdbId = $imdbId;

        return $this;
    }

    /**
     * Get imdbId
     *
     * @return string 
     */
    public function getImdbId()
    {
        return $this->imdbId;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Movie
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     * @return Movie
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Movie
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set votes
     *
     * @param integer $votes
     * @return Movie
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * Get votes
     *
     * @return integer 
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Set sortie
     *
     * @param \DateTime $sortie
     * @return Movie
     */
    public function setSortie($sortie)
    {
        $this->sortie = $sortie;

        return $this;
    }

    /**
     * Get sortie
     *
     * @return \DateTime 
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     * @return Movie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set realisateurs
     *
     * @param string $realisateurs
     * @return Movie
     */
    public function setRealisateurs($realisateurs)
    {
        $this->realisateurs = $realisateurs;

        return $this;
    }

    /**
     * Get realisateurs
     *
     * @return string 
     */
    public function getRealisateurs()
    {
        return $this->realisateurs;
    }

    /**
     * Set scenaristes
     *
     * @param string $scenaristes
     * @return Movie
     */
    public function setScenaristes($scenaristes)
    {
        $this->scenaristes = $scenaristes;

        return $this;
    }

    /**
     * Get scenaristes
     *
     * @return string 
     */
    public function getScenaristes()
    {
        return $this->scenaristes;
    }

    /**
     * Set acteurs
     *
     * @param string $acteurs
     * @return Movie
     */
    public function setActeurs($acteurs)
    {
        $this->acteurs = $acteurs;

        return $this;
    }

    /**
     * Get acteurs
     *
     * @return string 
     */
    public function getActeurs()
    {
        return $this->acteurs;
    }

    /**
     * Set resume
     *
     * @param string $resume
     * @return Movie
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string 
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return Movie
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set afficheUrl
     *
     * @param string $afficheUrl
     * @return Movie
     */
    public function setAfficheUrl($afficheUrl)
    {
        $this->afficheUrl = $afficheUrl;

        return $this;
    }

    /**
     * Get afficheUrl
     *
     * @return string 
     */
    public function getAfficheUrl()
    {
        return $this->afficheUrl;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     * @return Movie
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime 
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Movie
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }
}
