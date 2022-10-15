<?php
/**
 * @package        plg_content_qldiv
 * @copyright     Copyright (C) 2016 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

//no direct access
defined('_JEXEC') or die ('Restricted Access');

jimport('joomla.plugin.plugin');

class plgContentQldiv extends JPlugin
{

    protected $strTag = 'qldiv';

    /**
     * onContentPrepare :: some kind of controller of plugin
     * @param $strContext
     * @param $objArticle
     * @param $objParams
     * @param int $numPage
     * @return bool
     */
    public function onContentPrepare($strContext, &$objArticle, &$objParams, $numPage = 0)
    {
        if ($strContext == 'com_finder.indexer') {
            return true;
        }
        if (false === strpos($objArticle->text, $this->strTag)) {
            return true;
        }

        $objArticle->text = $this->clearTags($objArticle->text);

        /*set start tag*/
        $objArticle->text = $this->replaceStartTags($objArticle->text);

        /*set end tag*/
        $objArticle->text = $this->replaceEndTags($objArticle->text);
    }

    /**
     * @param $string
     * @return null|string|string[]
     */
    private function replaceStartTags($string)
    {
        $strRegex = '!{' . $this->strTag . '(\s){0,1}(.*?)}!';;
        preg_match_all($strRegex, $string, $arrMatches, PREG_SET_ORDER);
        if (0 === count($arrMatches)) {
            return $string;
        }
        foreach ($arrMatches as $arrValue) {
            $string = preg_replace('?' . $arrValue[0] . '?', '<div ' . $arrValue[2] . '>', $string);
        }
        return $string;
    }

    /**
     * method to get attributes
     * @param $string
     * @return mixed
     */
    private function replaceEndTags($string)
    {
        $string = str_replace('{/' . $this->strTag . '}', '</div>', $string);
        return $string;
    }

    /**
     * method to clear tags
     * @param $string
     * @return string
     */
    private function clearTags($string)
    {
        $string = str_replace('<p>{/' . $this->strTag . '}', '{/' . $this->strTag . '}', $string);
        $string = str_replace('{/' . $this->strTag . '}</p>', '{/' . $this->strTag . '}', $string);
        $string = str_replace('<p>{' . $this->strTag . '', '{' . $this->strTag . '', $string);
        $strRegex = '!{qldiv\s(.*?)}</p>!';
        preg_match_all($strRegex, $string, $arrMatches, PREG_SET_ORDER);
        if (0 === count($arrMatches)) {
            return $string;
        }

        foreach ($arrMatches as $numKey => $arrValue) {
            $string = preg_replace('?' . $arrValue[0] . '?', '{' . $this->strTag . ' ' . $arrValue[1] . '}', $string);
        }
        return $string;
    }

    /**
     * method to get matches according to search string
     * @param $strText
     * @param $strSearch
     * @return mixed
     */
    public function getMatches($strText, $strSearch)
    {
        $strSearch = preg_replace('!{\?}!', ' ', $strSearch);
        $strSearch = preg_replace('?/?', '\/', $strSearch);
        $strRegex = '/{' . $strSearch . '+(.*?)}/i';
        preg_match_all($strRegex, $strText, $arrMatches, PREG_SET_ORDER);
        return $arrMatches;
    }
}