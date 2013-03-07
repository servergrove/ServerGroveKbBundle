<?php

namespace ServerGrove\KbBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ServerGrove\KbBundle\Document\Article;
use ServerGrove\KbBundle\Document\Category;
use Symfony\Component\Locale\Locale;

/**
 * Class ArticlesController
 *
 * @Route("/{_locale}/rss")
 *
 * @author Raul Fraile<raul@servergrove.com>
 */
class RssController extends Controller
{

    /**
     *
     * @Route("/", name="sgkb_rss_index", defaults={"_format"="rss"})
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        $articles = $this->getArticleRepository()->findAll();

        return array(
            'articles' => $articles
        );
    }
}
