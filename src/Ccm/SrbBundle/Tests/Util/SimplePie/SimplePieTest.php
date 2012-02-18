<?php
// src/Ccm/SrbBundle/Tests/Util/SimplePieTest.php

namespace Ccm\SrbBundle\Tests\Util\SimplePie;

use Ccm\SrbBundle\Util\Structures_BibTex;
use Ccm\SrbBundle\Util\PEAR;
use Ccm\SrbBundle\Util\SimplePie\SimplePie;

class SimplePieTest extends \PHPUnit_Framework_TestCase
{
    public function testRef()
    {

        $base_url = 'http://export.arxiv.org/api/query?';
        // Search parameters
        // $search_query = 'au:Oeckl';
        $search_query = 'id_list=1109.5215';
        $start = 0;                     // retreive the first 5 results
        $max_results = 30;
        $query = $search_query."&start=".$start."&max_results=".$max_results;

        $feed = new SimplePie($base_url.$query);

        $feed->init();
        $feed->handle_content_type();

        $atom_ns = 'http://www.w3.org/2005/Atom';
        $opensearch_ns = 'http://a9.com/-/spec/opensearch/1.1/';
        $arxiv_ns = 'http://arxiv.org/schemas/atom';

        # print out feed information
        //print("<b>Print out feed information</b>".EOL);
        //print("Feed title: ".$feed->get_title().EOL);
        $last_updated = $feed->get_feed_tags($atom_ns,'updated');
        //print("Last Updated: ".$last_updated[0]['data'].EOL.EOL);

        # opensearch metadata such as totalResults, startIndex,
        # and itemsPerPage live in the opensearch namespase
        //print("<b>Opensearch metadata such as totalResults, startIndex, and itemsPerPage live in the opensearch namespase</b>".EOL);
        $totalResults = $feed->get_feed_tags($opensearch_ns,'totalResults');
        //print("totalResults for this query: ".$totalResults[0]['data'].EOL);

        $startIndex = $feed->get_feed_tags($opensearch_ns,'startIndex');
        //print("startIndex for these results: ".$startIndex[0]['data'].EOL);

        $itemsPerPage = $feed->get_feed_tags($opensearch_ns,'itemsPerPage');
        //print("itemsPerPage for these results: ".$itemsPerPage[0]['data'].EOL.EOL);

        # Run through each entry, and print out information
        # some entry metadata lives in the arXiv namespace
        //print("<b>Run through each entry, and print out information some entry metadata lives in the arXiv namespace</b>".EOL);
        $bibTex = new Structures_BibTex();
        
        foreach ($feed->get_items() as $entry) {

        $addarray = array();

        $addarray['entryType'] = 'Article';

        $temp = explode('/abs/',$entry->get_id());
        // print("arxiv-id: ".$temp[1].EOL);
        // print("Title: ".$entry->get_title());

        $addarray['arxiv'] = $temp[1];
        $this->assertArrayHasKey('arxiv', $addarray);
        
        $addarray['title'] = $entry->get_title();
        $this->assertArrayHasKey('title', $addarray);

        //$published = $entry->get_item_tags($atom_ns,'published');
        // print("Published: ".$published[0]['data'].EOL);

        // gather a list of authors and affiliation
        //  This is a little complicated due to the fact that the author
        //  affiliations are in the arxiv namespace (if present)
        // Manually getting author information using get_item_tags
        $authors = array();
        $i = 0;

        foreach ($entry->get_item_tags($atom_ns,'author') as $author) {
          $name = $author['child'][$atom_ns]['name'][0]['data'];

            // Convierte $name en last/first
            $lfname = explode(" ", $name);

            $addarray['author'][$i]['first'] = $lfname[0];
            $addarray['author'][$i++]['last']  = $lfname[1];
            $this->assertArrayHasKey('author', $addarray);

            array_push($authors,'    '.$name);
        }

        // $author_string = join('',$authors);
        //print("Authors: ".EOL.$author_string.EOL);

        // get the links to the abs page and pdf for this e-print
        foreach ($entry->get_item_tags($atom_ns,'link') as $link) {
          if ($link['attribs']['']['rel'] == 'alternate') {
            $addarray['url'] = $link['attribs']['']['href'];
            $this->assertArrayHasKey('url', $addarray);
            
                //print("abs page link: ".$link['attribs']['']['href'].EOL);
          } elseif ($link['attribs']['']['title'] == 'pdf') {
                  $addarray['file'] = $link['attribs']['']['href'];
                  $this->assertArrayHasKey('file', $addarray);
                //print("pdf link: ".$link['attribs']['']['href'].EOL);
          }
        }

# The journal reference, comments and primary_category sections live under
# the arxiv namespace
        $journal_ref_raw = $entry->get_item_tags($arxiv_ns,'journal_ref');
        
        if ($journal_ref_raw) {
          $journal_ref = $journal_ref_raw[0]['data'];
          $addarray['journal'] = $journal_ref_raw[0]['data'];
          $this->assertArrayHasKey('journal', $addarray);
        }

        $comments_raw = $entry->get_item_tags($arxiv_ns,'comment');
        
        if ($comments_raw) {
          $addarray['notas'] = $comments_raw[0]['data'];
          $this->assertArrayHasKey('notas', $addarray);
        }

        $primary_category_raw = $entry->get_item_tags($arxiv_ns, 'primary_category');
        $primary_category = $primary_category_raw[0]['attribs']['']['term'];
        // print("Primary Category: ".$primary_category.EOL);

        // Lets get all the categories
        $categories = array();

        foreach ($entry->get_categories() as $category) {
          array_push($categories,$category->get_label());
        }

        $categories_string = join(', ',$categories);
    
        $addarray['keywords'] = $categories_string;
        $this->assertArrayHasKey('keywords', $addarray);
        
        $addarray['abstract'] = $entry->get_description();
        $this->assertArrayHasKey('abstract', $addarray);


        $this->assertNotEmpty($addarray);
        $bibTex->addEntry($addarray);

        $this->assertArrayHasKey('entryType', $bibTex->data[0]);

        unset($addarray);
        
        } // For cada referencia

        //$bibTex->parse();
        $data = $bibTex->data;

        $this->assertArrayHasKey('entryType', $bibTex->data[0]);

        $this->assertNotEmpty($bibTex->data);

    }

    public function testArxiveError()
    {

        $base_url = 'http://export.arxiv.org/api/query?';
        // Search parameters
        // $search_query = 'au:Oeckl';
        $search_query = 'id_list=1109.5215x';
        $start = 0;                     // retreive the first 5 results
        $max_results = 30;
        $query = $search_query."&start=".$start."&max_results=".$max_results;

        $feed = new SimplePie($base_url.$query);

        $feed->init();
        $feed->handle_content_type();

        $atom_ns = 'http://www.w3.org/2005/Atom';
        $opensearch_ns = 'http://a9.com/-/spec/opensearch/1.1/';
        $arxiv_ns = 'http://arxiv.org/schemas/atom';

        foreach ($feed->get_items() as $entry) {

        $addarray = array();

        $addarray['title'] = $entry->get_title();

        $this->assertEquals('Error', $addarray['title']);
        
        // $error = $entry->get_description();

        $addarray['abstract'] = $entry->get_description();
        $this->assertArrayHasKey('abstract', $addarray);

        unset($addarray);

        } // For cada referencia
    }

    public function testArxiveNoExist()
    {

        $base_url = 'http://export.arxiv.org/api/query?';
        // Search parameters
        // $search_query = 'au:Oeckl';
        $search_query = 'id_list=1109.9000';
        $start = 0;                     // retreive the first 5 results
        $max_results = 30;
        $query = $search_query."&start=".$start."&max_results=".$max_results;

        $feed = new SimplePie($base_url.$query);

        $feed->init();
        $feed->handle_content_type();

        $atom_ns = 'http://www.w3.org/2005/Atom';
        $opensearch_ns = 'http://a9.com/-/spec/opensearch/1.1/';
        $arxiv_ns = 'http://arxiv.org/schemas/atom';

        foreach ($feed->get_items() as $entry) {

            $addarray = array();

            $addarray['title'] = $entry->get_title();

            $this->assertEquals('', $addarray['title']);
        
            // $error = $entry->get_description();

            // $addarray['abstract'] = $entry->get_description();
            // $this->assertArrayHasKey('abstract', $addarray);

            unset($addarray);

        } // For cada referencia
    }

    
    public function testBibStructure()
    {

        $bibTex = new Structures_BibTex();
        
        $addarray                       = array();
        $addarray['entryType']          = 'Article';
        $addarray['cite']               = 'art2';
        $addarray['title']              = 'Titel of the Article';
        $addarray['author'][0]['first'] = 'John';
        $addarray['author'][0]['last']  = 'Doe';
        $addarray['author'][1]['first'] = 'Jane';
        $addarray['author'][1]['last']  = 'Doe';

        $bibTex->addEntry($addarray);

        $this->assertCount(1, $bibTex->data);

        $this->assertArrayHasKey('entryType', $bibTex->data[0]);
        

    }

}