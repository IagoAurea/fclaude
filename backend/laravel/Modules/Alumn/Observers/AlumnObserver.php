<?php

namespace Modules\Alumn\Observers;

use Modules\Alumn\Entities\Alumn;

class AlumnObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \Modules\Alumn\Entities\Alumn  $alumn
     * @return void
     */
    public function created(Alumn $alumn)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \Modules\Alumn\Entities\Alumn  $alumn
     * @return void
     */
    public function updated(Alumn $alumn)
    {
        //
    }

    /**
     * Handle the alumn "deleted" event.
     *
     * @param  \Modules\Alumn\Entities\Alumn  $alumn
     * @return void
     */
    public function deleted(Alumn $alumn)
    {
        //
    }

    /**
     * Handle the alumn "forceDeleted" event.
     *
     * @param  \Modules\Alumn\Entities\Alumn  $alumn
     * @return void
     */
    public function forceDeleted(Alumn $alumn)
    {
        //
    }
}
