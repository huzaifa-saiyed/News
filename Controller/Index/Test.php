<?php

namespace Kitchen\News\Controller\Index;

class Test extends \Magento\Framework\App\Action\Action
{

	public function execute()
	{
		$textDisplay = new \Magento\Framework\DataObject(array('text' => 'News'));
		$this->_eventManager->dispatch('kitchen_news_display_text', ['event_news' => $textDisplay]);
		echo $textDisplay->getText();
		exit;
	}
}
