<?php

namespace BehatFakePointer;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Defines application features from the specific context.
 */
class FakePointerContext extends RawMinkContext implements Context
{
    /**
     * @When I move fake pointer to :identifier
     */
    public function iMoveFakePointerToFollow(string $identifier)
    {
        $xPath = $this->getElementXPath($identifier);
        $this->getSession()->executeScript("behatFakePointer.pointerMove(\"{$xPath}\");");

        sleep(1);
    }

    /**
     * @When I click fake pointer
     *
     * Perform an animation to imply making a click.
     */
    public function iClickFakePointer()
    {
        $this->getSession()->executeScript("behatFakePointer.pointerClick();");
    }

    /**
     * @When I highlight element with fake pointer
     */
    public function iPointFakePointer()
    {
        $this->getSession()->executeScript("behatFakePointer.pointerHighlight();");

        sleep(1);
    }

    /**
     * @When I focus on :identifier
     */
    public function iFocusOnInput(string $identifier)
    {
        $xPath = $this->getElementXPath($identifier);
        $this->getSession()->executeScript("behatFakePointer.elementFocus(\"{$xPath}\");");
    }

    /**
     * @When I scroll to :identifier
     *
     * Sometimes elements can't be interacted with because they're on the edge
     * or just outside the viewport. Use this to reposition the page to expose
     * the element.
     */
    public function scrollIntoView(string $identifier)
    {
        $xPath = $this->getElementXPath($identifier);
        $this->getSession()->executeScript("behatFakePointer.elementScrollTo(\"{$xPath}\");");
    }

    /**
     * @When I set window size to :width wide and :height high
     *
     * The browser window has to be open before the size can be set.
     */
    public function iSetWindowSizeToWideAndHigh(string $width, string $height)
    {
        $this->getSession()->resizeWindow((int) $width, (int) $height);
    }

    /**
     * @When I display start recording message
     */
    public function startRecordingWarning()
    {
        $output =  <<<END


    ************************
    *** \e[1;93mSTART RECORDING\e[0;93m \e[0m ***
    ************************



END;
        fwrite(STDOUT, $output);
    }

    /**
     * @When I display stop recording message
     */
    public function stopRecordingWarning()
    {
        $output =  <<<END


    ***********************
    *** \e[1;93mSTOP RECORDING\e[0;93m \e[0m ***
    ***********************



END;
        fwrite(STDOUT, $output);
    }

    /**
     * Return the xPath for a matching element identified by the given string.
     * The identifier can contain xPAth, CSS, or text.
     *
     * @param string $identifier
     * @return string
     */
    private function getElementXPath(string $identifier)
    {
        $element = null;
        $page = $this->getSession()->getPage();

        if (preg_match('/^\/+/', $identifier))
            $element = $page->find('xpath', $identifier);
        else
            $element = $page->find('css', $identifier);

        // Try and find an input from a linked label.
        if (empty($element)) {
            $element = $page->find('xpath',  "//label[contains(text(),'{$identifier}')]");

            if (!empty($element) && $element->getAttribute('for'))
                $element = $page->find('css' , '#' . $element->getAttribute('for'));
        }

        // Try and find an element with matching text.
        if (empty($element))
            $element = $page->find('xpath',  "//*[contains(text(),'{$identifier}')]");

        if (empty($element))
            throw new \RuntimeException("Cannot find element with identifier '{$identifier}'");

        return $element->getXpath();
    }
}
