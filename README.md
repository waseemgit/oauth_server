# oauth_server
Restful API Test (For only Server Side) an API and the whole logic behind the server
=====================================================================================

=>For database host username and password and other constants editing you need to go to includes/config.php

=>Import sql file placed on root called --sql.sql-- and execute it in database name test_api.

=>SQL Test you can find it in --sql_test.sql--

Following is detail of All APIs with examples

Detailed log of the API structure and functionality
===================================================

Authorize API
=============

For testing client id and client secret are following

client_id : 123456789

client_secret : 25f9e794323b453885f5181f1b624d0b

URL     :   http://localhost/oauth_server/authorize

METHOD  :   POST

MANDATORY PARAMETERS : client_id  ,  client_secret   

RESPONSE :  {    "access_token": "f97cbbc0fce4f6b9623649e4a80f06b5" }

PURPOSE : GET access_token and use it in all APIs of application for security purpose. 
            Once you get token save it in session on client side and use this to access 
            all other APIs where it will be mandatory. This token will expire in 10000 minutes. You can 
change expiry time from includes/config.php  TOKEN_EXPIRY_TIME which is in minutes.

For testing you can use client_id=123456789 and client_secret=25f9e794323b453885f5181f1b624d0b 

EXAMPLE : 

<form action="http://localhost/oauth_server/authorize" method="post">
<input type="submit" value="submit" />
<input type="hidden" name="client_id" value="123456789" />
<input type="hidden" name="client_secret" value="25f9e794323b453885f5181f1b624d0b" />
</form>


Recent Answers API            
==================
URL : http://localhost/oauth_server/answers/recent/{client_id}/{access_token}

METHOD  :   GET

MANDATORY PARAMETERS : client_id  ,  access_token   

RESPONSE :[{title, description, uri}, {}, ....]

PURPOSE : GET top 10 recent answers You can change limit of records and URI of answer details API 
          from includes/config.php.

EXAMPLE : 

http://localhost/oauth_server/answers/recent/123456789/406a2fad291eec56e6e181a900b4cc1c 



Search Answers API
==================
URL : http://localhost/oauth_server/answers/search/{search_string}/{client_id}/{access_token}

METHOD  :   GET

MANDATORY PARAMETERS : search_string , client_id  ,  access_token   

RESPONSE :[{title, description, uri}, {}, ....]

PURPOSE : GET searched answers You can change URI of answer details API 
          from includes/config.php.

EXAMPLE:

http://localhost/oauth_server/answers/search/an/123456789/406a2fad291eec56e6e181a900b4cc1c

List all Answers API
====================

URL : http://localhost/oauth_server/answers/{client_id}/{access_token}

METHOD  :   GET

MANDATORY PARAMETERS : client_id  ,  access_token   

RESPONSE :[{title, created_by, created_at,total_comments}, {}, ....]

PURPOSE : GET all answers list.

EXAMPLE:

http://localhost/oauth_server/answers/123456789/406a2fad291eec56e6e181a900b4cc1c



Get Detail of an Answer API
===========================

URL : http://localhost/oauth_server/answers/detail/{answer_id}/{client_id}/{access_token}

METHOD  :   GET

MANDATORY PARAMETERS : answer_id, client_id  ,  access_token   

RESPONSE :{title, content, createdBy, createdAt, files: [{fileName, fileURI}, {}, ....], comments:[{text, createdBy, createdAt, files:
[{fileName, fileURI}, {}, ....]}, {}, ....]}

PURPOSE : GET detail of an answer.

EXAMPLE:

http://localhost/oauth_server/answers/detail/1/123456789/406a2fad291eec56e6e181a900b4cc1c



Update Search Count Answer API
==============================

URL : http://localhost/oauth_server/answers/update_search_count/{answer_id}/{client_id}/{access_token}

METHOD  :   PUT

MANDATORY PARAMETERS : answer_id, client_id ,access_token   

RESPONSE :{"msg":"success"}

PURPOSE : When on client side answer title will be searched and suggestion list comes after that when client's
click on some of his choice suggested search result,this API will be called to update in database that it is searched
how many times, so in future we can list down the most searched answers.

EXAMPLE:

Note: To test this I used Rest Console plugin of google chrome browser because its method is PUT ,Please use rest console for output

http://localhost/oauth_server/answers/update_search_count/1/123456789/406a2fad291eec56e6e181a900b4cc1c



Most Searched Answers API
==============================

URL : http://localhost/oauth_server/answers/most_searched/{client_id}/{access_token}

METHOD  :   GET

MANDATORY PARAMETERS : client_id  ,  access_token   

RESPONSE :[{title, description, uri}, {}, ....]

PURPOSE : GET top 10 most searched answers You can change limit of records and URI of answer details API 
          from includes/config.php.

EXAMPLE:

http://localhost/oauth_server/answers/most_searched/123456789/406a2fad291eec56e6e181a900b4cc1c



Create an Answer API
======================

URL : http://localhost/oauth_server/answers/create

METHOD  :   POST

MANDATORY PARAMETERS : client_id  ,  access_token , title ,   description, created_by 

NON MANDATORY PARAM  : file

RESPONSE :{"msg":"success","answer_id":"14"}

PURPOSE : Create answer with upload option of multiple files .
            You can change Upload files directory from includes/config.php.


EXAMPLE: 

<form action="http://localhost/oauth_server/answers/create" method="post" enctype="multipart/form-data">
<input type="submit" value="submit" />
<input type="hidden" name="client_id" value="123456789" />
<input type="hidden" name="access_token" value="406a2fad291eec56e6e181a900b4cc1c" />
<input type="hidden" name="title" value="test title" />
<input type="hidden" name="description" value="test description" />
<input type="hidden" name="created_by" value="1" />
<input type='file' name='file[]' ><br>
<input type='file' name='file[]' ><br>
</form>



Create Comment API
======================

URL : http://localhost/oauth_server/comments/create

METHOD  :   POST

MANDATORY PARAMETERS : client_id  ,  access_token , comment ,   answer_id, created_by 

NON MANDATORY PARAM  : file

RESPONSE :{"msg":"success","comment_id":"14"}

PURPOSE : Create comment with upload option of multiple files .
            You can change Upload files directory from includes/config.php.


EXAMPLE: 

<form action="http://localhost/oauth_server/comments/create" method="post" enctype="multipart/form-data">
<input type="submit" value="submit" />
<input type="hidden" name="client_id" value="123456789" />
<input type="hidden" name="access_token" value="406a2fad291eec56e6e181a900b4cc1c" />
<input type="hidden" name="comment" value="test comment" />
<input type="hidden" name="answer_id" value="1" />
<input type="hidden" name="created_by" value="1" />
<input type='file' name='file[]' ><br>
<input type='file' name='file[]' ><br>
</form>







