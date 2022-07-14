$('.x-reference-url').on('input focus', function(e)
    {

				spUrl = $(this).val();

				if(!spUrl)
                {
                    return false;
                }


                spUrl  = spUrl.replace('https://','url:');
                spUrl = spUrl.replace('http://','url:');


                src = $('#meta-parse').val();
        		src     = src + '?url=' + encodeURIComponent(spUrl);


                var target = $(this).attr('id');

                var targetTitle = '#'+ target.replace('url-url','url-name');
                var targetDescription = '#'+ target.replace('url-url','url-description');

                $(targetTitle).val('Loading....');
                $(targetDescription).val('Loading....');

				$.ajax({
				 url: src,
				 type:'get',
                    success: function(data){
                      if(data)
                      {
                          var a = $.parseJSON(data);
                        //   console.log(a.description);
                            $(targetTitle).val(a.title);
                            $(targetDescription).val(a.description);
                      }


                    },
                     error: function() {
                        console.log("Couldn't get title for " + spUrl);
                         $(targetTitle).val('Loading Failed!');
                     }
                })



    }
);

