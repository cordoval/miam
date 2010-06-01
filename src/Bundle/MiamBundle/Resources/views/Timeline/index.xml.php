<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/"> 
  <channel> 
    <title>knpLabs Miam</title> 
    <link>http://miam.knplabs.com</link> 
    <description></description> 
    <pubDate><?php echo date(DATE_RSS) ?></pubDate> 
    <managingEditor>knpLabs</managingEditor> 
    <language>fr</language> 
    <?php foreach ($timeline as $entry): ?>
    <item> 
      <title><![CDATA[<?php echo strtr(
                '{user} ' . $entry->renderAction() . ' {date}',
                array(
              '{story}' => $entry->getStory()->getName() . ' [' . $entry->getStory()->getProject()->getName() . ']',
              '{user}' => $entry->getUser()->getUsername(),
              '{date}' => 'à ' . $entry->getCreatedAt()->format('H:i'),
        )) ?>]]></title> 
      <link><?php echo $view->router->generate('story', array('id' => $entry->getStory()->getId()), true) ?></link> 
      <description><![CDATA[<?php echo strtr(
              '<b class="tentry_user">{user}</b> ' . $entry->renderAction() . ' {date}',
              array(
            '{story}' => '<a href="' . $view->router->generate('story', array('id' => $entry->getStory()->getId())) . '">'. $entry->getStory()->getName() . ' [' . $entry->getStory()->getProject()->getName() . ']</a>',
            '{user}' => $entry->getUser()->getUsername(),
            '{date}' => '<span class="tentry_ago">à ' . $entry->getCreatedAt()->format('H:i') . '</span>',
      )) ?>]]></description> 
      <guid isPermaLink="false"></guid> 
      <pubDate><?php echo $entry->getCreatedAt()->format(DATE_RSS) ?></pubDate> 
    </item>
    <?php endforeach ?>
  </channel> 
</rss>
