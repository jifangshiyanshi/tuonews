<script id="page_template" type="text/html">
    <% for (var i = 0; i < list.length; i ++) { %>
    <li class="item">
        <div class="img_box">
            <a href="<%= list[i].url %>">
                <!--180x126-->
                <img src="<%= list[i].thumb %>" alt="<%= list[i].title %>"/>
            </a>
        </div>
        <div class="text_box">
            <h1 class="head"><a href="<%= list[i].url %>"><%= list[i].title %></a></h1>
            <div class="info">
                <div class="tag">
                    <% for (var j = 0; j < list[i].__tags.length; j ++) { %>
                    <a href="<%= list[i].__tags[j].tag_url %>"><%= list[i].__tags[j].name %></a>
                    <% } %>
                </div>
                <a href="<%= list[i].media_url %>"><%= list[i].media_name %></a>
                <span class="date"><%= list[i].add_time %></span>
                <a href="<%= list[i].chanel_url %>"><%= list[i].chanel_name %></a>
            </div>
            <div class="dec"><%= list[i].bcontent %></div>
        </div>
    </li>
    <% } %>
</script>

<button class="btn page_ajax" id="page_ajax" data-ajax-url="/article_article_ajaxArticle" data-ajax-data='{"page":"1"}'>加载更多</button>
