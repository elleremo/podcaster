<?php
echo '<?xml version="1.0" encoding="' . get_option( 'blog_charset' ) . '"?' . '>';
?>
<rss version="2.0">
    <channel>
        <title><?php bloginfo_rss( 'name' ); ?></title>
        <link><?php bloginfo_rss( 'url' ); ?></link>
        <description><?php bloginfo_rss( 'description' ); ?></description>
        <language><?php echo substr( get_bloginfo_rss( 'language' ), 0, strpos( get_bloginfo_rss( 'language' ), '-' ) );?></language>

            <item>
                <title><?php the_title_rss(); ?></title>
                <link><?php the_permalink_rss(); ?></link>
                <guid><?php the_guid(); ?></guid>
                <pubDate><?php echo get_post_time( 'r', true ); ?></pubDate>
                <author><?php the_author(); ?></author>
                <description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
                <content:encoded>
                    <![CDATA[<?php the_content_feed(); ?>]]>
                </content:encoded>

            </item>
    </channel>
</rss>
