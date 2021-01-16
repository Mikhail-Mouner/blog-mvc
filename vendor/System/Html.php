<?php
namespace System;

class Html
{
    protected $application;
    private $title;
    private $description;
    private $keywords;
    
    public function __construct(Application $app) {
        $this->application = $app;
    }

    /**
     * Set  Title
     * 
     * @param string $title
     * @return void
     *   */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get  Title
     * 
     * @return string
     *   */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set  Description
     * 
     * @param string $description
     * @return void
     *   */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Get  Description
     * 
     * @return string
     *   */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set  Keywords
     * 
     * @param string $keywords
     * @return void
     *   */
    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }

    /**
     * Get  Keywords
     * 
     * @return string
     *   */
    public function getKeywords() {
        return $this->keywords;
    }

}