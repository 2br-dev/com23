{addcss file="%metavalidation%/metavalidation.css"}
<p><strong>{t}Теги meta, которые необходимо добавить в секцию HEAD{/t}</strong></p>
<div id="meta-tags">
{foreach $elem.meta_tags.name as $key => $data}
<div class="one-meta"><a class="meta-delete" title="{t}Удалить{/t}">&times;</a>&nbsp;&nbsp;&nbsp; &lt;meta name= <input type="text" name="meta_tags[name][]" value="{$data}">&nbsp;&nbsp;&nbsp;content= <input type="text" size="40" name="meta_tags[content][]" value="{$elem.meta_tags.content[$key]}">&gt;</div>
{/foreach}
</div><br>
<a id="add-meta-line"><u>{t}Добавить тег meta{/t}</u></a>
<script type="text/javascript">
    $(function() {
        $('#add-meta-line').click(function() {
            $('#meta-tags').append(
                '<div class="one-meta"><a class="meta-delete" title="{t}Удалить{/t}">&times;</a>&nbsp;&nbsp;&nbsp; &lt;meta name= <input type="text" name="meta_tags[name][]">&nbsp;&nbsp;&nbsp;content= <input type="text" size="40" name="meta_tags[content][]">&gt;</div>'
            ).trigger('new-content');
        });
        
        $('#meta-tags').on('click', '.meta-delete', function() {
            $(this).closest('.one-meta').remove();
        });
    });
</script>