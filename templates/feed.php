<?php
/** @var TYPE_NAME $atts */
echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?' . '>'; ?>

<rss version="2.0"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:wfw="http://wellformedweb.org/CommentAPI/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
     xmlns:googleplay="http://www.google.com/schemas/play-podcasts/1.0"
     xmlns:fh="http://purl.org/syndication/history/1.0"
     xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:creativeCommons="http://backend.userland.com/creativeCommonsRssModule"
>
    <channel>
        <title>Подкасты Mojo Media</title>
        <atom:link href="https://mojomedia.ru/feed-podcasts/all" rel="self" type="application/rss+xml"/>
        <itunes:keywords>Mojo media , Mojo podcasts,Дикие утки, Работник месяца, Ребята, мы потрахались , Мы в этом
            живем, Подкасты, подкаст, itunes, podster , soundcloud
        </itunes:keywords>
        <link>https://mojomedia.ru</link>
        <pubDate>Wed, 04 Jan 2017 08:52:14 +0000</pubDate>
        <ttl>60</ttl>
        <webMaster>feeds@soundcloud.com (SoundCloud Feeds)</webMaster>
        <description>Подкасты издательства Mojo Media - дикие утки, работник месяца, ребята, мы потрахались и мы в этом
            живем
        </description>
        <lastBuildDate>Thu, 23 May 2019 22:05:00 +0000</lastBuildDate>
        <language>ru</language>
        <copyright>All rights reserved MojoMedia</copyright>
        <itunes:author>Команда MojoMedia</itunes:author>
        <googleplay:author>Команда MojoMedia</googleplay:author>
        <googleplay:email>bilirium@gmail.com</googleplay:email>
        <itunes:summary>Подкасты издательства Mojo Media - дикие утки, работник месяца, ребята, мы потрахались и мы в
            этом живем
        </itunes:summary>
        <googleplay:description>Подкасты издательства Mojo Media - дикие утки, Работник месяца, ребята, мы потрахались и
            мы в этом живем
        </googleplay:description>
        <itunes:owner>
            <itunes:name>Команда MojoMedia</itunes:name>
            <itunes:email>bilirium@gmail.com</itunes:email>
        </itunes:owner>

        <itunes:explicit>yes</itunes:explicit>
        <googleplay:explicit>yes</googleplay:explicit>
        <itunes:image href="https://mojomedia.ru/wp-content/uploads/2018/09/cropped-icon.png"/>
        <googleplay:image href="https://mojomedia.ru/wp-content/uploads/2018/09/cropped-icon.png"/>
        <image>
            <url>https://mojomedia.ru/wp-content/uploads/2018/09/cropped-icon.png</url>
            <title>Подкасты Mojo Media</title>
            <link>
            https://mojomedia.ru</link>
        </image>
        <itunes:image href="https://mojomedia.ru/wp-content/uploads/2018/09/cropped-icon.png"/>

        <itunes:category text="Society &amp; Culture"/>
        <media:copyright>All rights reserved MojoMedia</media:copyright>
        <media:thumbnail url="https://mojomedia.ru/wp-content/uploads/2018/09/cropped-icon.png"/>
        <media:keywords>Mojo media , Mojo podcasts,Дикие утки, Работник месяца, Ребята, мы потрахались , Мы в этом
            живем, Подкасты, подкаст, itunes, podster , soundcloud
        </media:keywords>
        <creativeCommons:license>https://creativecommons.org/licenses/by/4.0/</creativeCommons:license>
        <generator><?php the_generator('atom'); ?></generator>

        <?php foreach ($atts['posts'] as $post) : ?>

            <item>
                <title><?php echo esc_html($post->post_title); ?></title>
                <link><?php echo esc_html(add_query_arg(site_url(), ['?' => get_the_ID()])); ?></link>
                <pubDate><?php echo esc_html(mysql2date('D, d M Y H:i:s +0000', $post['post_date'], false)); ?></pubDate>

                <guid isPermaLink="false"><?php echo esc_html(add_query_arg(site_url(), ['p' => $post['ID']])); ?></guid>
                <itunes:subtitle><![CDATA[<?php echo $post['meta']['subtitle']; ?>]]></itunes:subtitle>
                <itunes:image href="<?php echo $post['thumbnail'];?>"/>

                <description><![CDATA[<?php echo $post['meta']['description']; ?>]]></description>
                <googleplay:description><![CDATA[<?php echo $post['meta']['description']; ?>]]></googleplay:description>
                <content:encoded><![CDATA[<?php echo $post['meta']['description']; ?>]]></content:encoded>

                <itunes:summary><![CDATA[<?php echo $post['meta']['summary']; ?>]]></itunes:summary>


                <enclosure url="<?php echo $post['meta']['audio_meta']['url']; ?>"
                           length="<?php echo $post['meta']['audio_meta']['fileSize']; ?>"
                           type="<?php echo $post['meta']['audio_meta']['type']; ?>"/>
                <media:content url="<?php echo $post['meta']['audio_meta']['url']; ?>"
                               fileSize="<?php echo $post['meta']['audio_meta']['fileSize']; ?>"
                               type="<?php echo $post['meta']['audio_meta']['type']; ?>"/>

                <itunes:explicit><?php echo $post['meta']['explicit']; ?></itunes:explicit>
                <googleplay:explicit><?php echo $post['meta']['explicit']; ?></googleplay:explicit>

                <itunes:duration><?php $post['meta']['audio_meta']['duration']; ?></itunes:duration>

                <dc:creator><?php echo $post['meta']['author']; ?></dc:creator>
                <itunes:author><?php echo $post['meta']['author']; ?></itunes:author>
            </item>

        <?php endforeach; ?>

    </channel>
</rss>
