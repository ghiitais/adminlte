<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Brexis\LaravelWorkflow\Traits\WorkflowTrait;

class BlogPost extends Model
{
    use WorkflowTrait;
    /**
     * @var string
     */
    private $title;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string
     */
    private $currentPlace;


    /**
     * PullRequest constructor.
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->currentPlace = 'draft';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return PullRequest
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return PullRequest
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentPlace()
    {
        return $this->currentPlace;
    }

    /**
     * @param string $state
     *
     * @return PullRequest
     */
    public function setState(string $state)
    {
        $this->currentPlace = $state;
        return $this;
    }

}




