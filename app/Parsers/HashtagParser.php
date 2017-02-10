<?php

namespace App\Parsers;

use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\InlineParserContext;

class HashtagParser extends AbstractInlineParser
{
    public function getCharacters()
    {
        return ['#'];
    }

    public function parse(InlineParserContext $inlineContext)
    {
        $cursor = $inlineContext->getCursor();

        // The # symbol must not have any other characters immediately prior
        $previousChar = $cursor->peek(-1);

        if ($previousChar !== null && $previousChar !== ' ') {
            // peek() doesn't modify the cursor, so no need to restore state first
            return false;
        }

        // Save the cursor state in case we need to rewind and bail
        $previousState = $cursor->saveState();

        // Advance past the # symbol to keep parsing simpler
        $cursor->advance();

        // Parse the tag
        $tag = $cursor->match('/^[A-Za-z0-9_]{1,100}(?!\w)/');

        if (empty($tag)) {
            // Regex failed to match; this isn't a valid Twitter handle
            $cursor->restoreState($previousState);
            return false;
        }

        // Need to dispatch here to attach the tag (or queue for tagging) to the post
        //dd(app('tagqueue')); //[] = $tag;

        app('tagqueue')->addTag($tag);

        $tagUrl = '/tag/' . $tag;

        $inlineContext->getContainer()->appendChild(new Link($tagUrl, '#' . $tag));

        return true;
    }
}