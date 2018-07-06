<?php

namespace App\Modules\Newsletters;

use Illuminate\Http\Request;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;
use App\Classes\Library\PageLoader\Frontpage;
use App\Plugins\Newsletters\Model\Newsletter;
use App\Plugins\Newsletters\Model\NewsletterUser;
use App\Plugins\Newsletters\Model\NewsletterRepository;

/**
 * Class FrontendController.
 */
class FrontendController
{
    /**
     * Add a user to the newsletter user email mailing list.
     *
     * @param Request $request
     * @param NewsletterUser $newsletterUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function joinNewsletter(Request $request, NewsletterUser $newsletterUser)
    {
        try {
            $newsletterUser->setAttribute('email', $request['email_address'])->save();
        } catch (\Exception $e) {
            //
        }

        return redirect()->route('newsletter.complete');
    }

    /**
     * Remove a user from the newsletter user email mailing list.
     *
     * @param Request $request
     * @param NewsletterRepository $newsletterRepository
     */
    public function leaveNewsletter(Request $request, NewsletterRepository $newsletterRepository)
    {
        //
    }

    /**
     * Return the user to a thank you message to notify of a completed registration.
     *
     * @return \Illuminate\Http\Response
     */
    public function completedNewsletter()
    {
        $page = app(PageRepository::class)->whereIdentifier(Newsletter::VIEW_NEWSLETTER_SUCCESS);

        return (new Frontpage($page, app(MenuRepository::class)->allParentsWithChildren()))->publish();
    }
}
