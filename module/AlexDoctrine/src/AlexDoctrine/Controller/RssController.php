<?php

namespace AlexDoctrine\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//for reading rss
use Zend\Feed\Reader\Reader;
use Zend\Feed\Reader\Exception\RuntimeException;
//for validation rss
use Zend\Validator\Uri;
use Zend\Escaper\Escaper;

class RssController extends AbstractActionController
{

    private $rss_ste = 'http://zendguru.wordpress.com/feed/';
 /**
     *  the main method which allow to see form and calls list under the form
     * @return view object with form and calls
     *
     */
    public function indexAction()
    {
      
//        try {
//            $rss = Reader::import($this->rss_ste);
//        } catch (RuntimeException $e) {
//            // feed import failed
//            echo "Exception caught importing feed: {$e->getMessage()}\n";
//            exit;
//        }
//
//        // Validate all URIs
//        $linkValidator = new Uri();
//        $link = null;
//        if ($linkValidator->isValid($rss->getLink())) {
//            $link = $rss->getLink();
//        }
//
//        // Escaper used for escaping data
//        $escaper = new Escaper('utf-8');
//
//        // Initialize the channel data array
//        $channel = array(
//            'title'       => $escaper->escapeHtml($rss->getTitle()),
//            'link'        => $escaper->escapeHtml($link),
//            'description' => $escaper->escapeHtml($rss->getDescription()),
//            'items'       => array()
//        );
//
//        // Loop over each channel item and store relevant data
//        foreach ($rss as $item) {
//            $link = null;
//            if ($linkValidator->isValid($rss->getLink())) {
//                $link = $item->getLink();
//            }
//            $channel['items'][] = array(
//                'title'       => $escaper->escapeHtml($item->getTitle()),
//                'link'        => $escaper->escapeHtml($link),
//                'description' => $escaper->escapeHtml($item->getDescription())
//            );
//        }
 
        return new ViewModel(array(
          //  'rss' => $data
        ));

    }
 


}
