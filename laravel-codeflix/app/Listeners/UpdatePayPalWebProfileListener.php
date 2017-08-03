<?php

namespace CodeFlix\Listeners;

use CodeFlix\Models\PayPalWebProfile;
use CodeFlix\PayPal\WebProfileClient;
use CodeFlix\Repositories\PayPalWebProfileRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;

class UpdatePayPalWebProfileListener
{
    /**
     * @var WebProfileClient
     */
    private $webProfileClient;
    /**
     * @var PayPalWebProfileRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(WebProfileClient $webProfileClient, PayPalWebProfileRepository $repository)
    {
        //
        $this->webProfileClient = $webProfileClient;
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEntityUpdated  $event
     * @return void
     */
    public function handle(RepositoryEntityUpdated $event)
    {
        $model = $event->getModel();
        if(!($model instanceof PayPalWebProfile)){
            return;
        }

        if(!\Config::get('webprofile_created')){
            $this->webProfileClient->update($model);
        }

    }
}
