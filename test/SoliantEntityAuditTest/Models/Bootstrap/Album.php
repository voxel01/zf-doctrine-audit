<?php

namespace SoliantEntityAuditTest\Models\Bootstrap;

use Doctrine\ORM\Mapping\ClassMetadata
    , Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder
    , Doctrine\Common\Collections\ArrayCollection
    ;

class Album {

    private $id;
    private $artist;
    private $title;
    private $songs;
    private $performers;

    public function getId()
    {
        return $this->id;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    public function setArtist($value)
    {
        $this->artist = $value;
        return $this;
    }

    public function setTitle($value)
    {
        $this->title = $value;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSongs()
    {
        if (!$this->songs)
            $this->songs = new ArrayCollection();

        return $this->songs;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->createField('id', 'integer')->isPrimaryKey()->generatedValue()->build();

        $builder->addField('artist', 'string', array('nullable' => true));
        $builder->addField('title', 'string');
        $builder->addOneToMany('songs', 'Song', 'album');
        $builder->addInverseManyToMany('performers', 'Performer', 'albums');
    }
}