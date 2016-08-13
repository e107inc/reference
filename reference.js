$('.x-reference-url').on('keyup change', function(e)
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

                target = '#'+ target.replace('url-url','url-name');


				$.ajax({
				 url: src,
				 type:'get',
                    success: function(data){
                      if(data)
                      {
                         //   console.log(data);
                            $(target).val(data);
                      }


                    },
                     error: function() {
                        console.log("Couldn't get title for " + spUrl);
                     }
                })



    }
);

