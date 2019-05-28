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
        <link>
        https://mojomedia.ru</link>
        <description>Подкасты издательства Mojo Media - дикие утки, работник месяца, ребята, мы потрахались и мы в этом
            живем
        </description>
        <pubDate>Wed, 04 Jan 2017 08:52:14 +0000</pubDate>
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
        <itunes:category text="Society &amp; Culture"/>
        <media:copyright>All rights reserved MojoMedia</media:copyright>
        <media:thumbnail url="https://mojomedia.ru/wp-content/uploads/2018/09/cropped-icon.png"/>
        <media:keywords>Mojo media , Mojo podcasts,Дикие утки, Работник месяца, Ребята, мы потрахались , Мы в этом
            живем, Подкасты, подкаст, itunes, podster , soundcloud
        </media:keywords>
        <creativeCommons:license>https://creativecommons.org/licenses/by/4.0/</creativeCommons:license>
        <generator>https://wordpress.org/?v=5.2.1</generator>

        <?php foreach ($atts['posts'] as $post) : ?>

            <item>
                <title><?php echo esc_html($post->post_title); ?></title>
                <link><?php echo esc_html(add_query_arg(site_url(), ['?' => get_the_ID()])); ?></link>
                <pubDate><?php echo esc_html(mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true, $post), false)); ?></pubDate>
                <dc:creator>Команда MojoMedia</dc:creator>
                <guid isPermaLink="false">https://mojomedia.ru/?post_type=audio&#038;p=1037</guid>
                <description><![CDATA[Праздники закончились, пора возвращаться в реальность. И чтоб вам было не так грустно, записали подкаст. Не грустите.]]></description>

                <itunes:subtitle>
                    <![CDATA[Праздники закончились, пора возвращаться в реальность. И чтоб вам было не так грустно, записали подкаст. Не грустите.... ]]>
                </itunes:subtitle>
                <itunes:image href="https://mojomedia.ru/wp-content/uploads/2018/09/my-v-etom-zhivyom.png"/>
                <content:encoded><![CDATA[Праздники закончились, пора возвращаться в реальность. И чтоб вам было не так грустно, записали подкаст. Не грустите.]]>
                </content:encoded>
                <itunes:summary><![CDATA[Праздники закончились, пора возвращаться в реальность. И чтоб вам было не так грустно, записали подкаст. Не грустите.]]>
                </itunes:summary>
                <googleplay:description><![CDATA[Праздники закончились, пора возвращаться в реальность. И чтоб вам было не так грустно, записали подкаст. Не грустите.]]>
                </googleplay:description>
                <enclosure url="https://mojomedia.ru/wp-content/uploads/2019/05/Vypusk-31-s04-Zanudstvo.mp3"
                           length="120792756"
                           type="audio/mpeg"/>
                <media:content url="https://mojomedia.ru/wp-content/uploads/2019/05/Vypusk-31-s04-Zanudstvo.mp3"
                               fileSize="120792756"
                               type="audio/mpeg"/>
                <itunes:explicit>yes</itunes:explicit>
                <googleplay:explicit>yes</googleplay:explicit>
                <itunes:duration>50:20</itunes:duration>
                <itunes:author>Команда MojoMedia</itunes:author>
            </item>

        <?php endforeach; ?>

    </channel>
</rss>
