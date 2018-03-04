<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/05/2016
 * Time: 22:27.
 */

namespace App\Plugins\Newsletters;

use App\Classes\Library\PageLoader\Frontpage;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;
use App\Model\Page;
use App\Plugins\Newsletters\Model\Newsletter;
use App\Plugins\Newsletters\Model\NewsletterRepository;
use App\Plugins\Newsletters\Model\NewsletterUser;
use App\Plugins\PluginEngine;
use Illuminate\Http\Request;

/**
 * Class FrontendController.
 */
class FrontendController extends PluginEngine
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
