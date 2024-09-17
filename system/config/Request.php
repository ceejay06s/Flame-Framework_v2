<?php

namespace System\Config;

#[\AllowDynamicProperties]
class Request
{
    public function __construct()
    {
        $this->server = $_SERVER;
        $this->get = $this->serializer($_GET);
        $this->post = $this->serializer($_POST);
        $this->files = $_FILES;
        $this->cookie = $_COOKIE;
        $this->session = $_SESSION;
    }

    public function serializer($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->serializer($value);
            } else if (is_string($value)) {
                if (json_decode($value, true)) {
                    $array[$key] = json_decode($value, true);
                } else {
                    $array[$key] = htmlentities($value);
                }
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }



    public function server($key = null)
    {
        if ($key === null) {
            return $this->server;
        }
        return $this->server[$key] ?? null;
    }

    public function get($key = null)
    {
        if ($key === null) {
            return $this->get;
        }
        return $this->get[$key] ?? null;
    }

    public function post($key = null)
    {
        if ($key === null) {
            return $this->post;
        }
        return $this->post[$key] ?? null;
    }

    public function files($key = null)
    {
        if ($key === null) {
            return $this->files;
        }
        return $this->files[$key] ?? null;
    }

    public function cookies($key = null)
    {
        if ($key === null) {
            return $this->cookie;
        }
        return $this->cookie[$key] ?? null;
    }

    public function session($key = null)
    {
        if ($key === null) {
            return $this->session;
        }
        return $this->session[$key] ?? null;
    }

    public function isAjax()
    {
        return isset($this->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function isPost()
    {
        return $this->server['REQUEST_METHOD'] === 'POST';
    }

    public function isGet()
    {
        return $this->server['REQUEST_METHOD'] === 'GET';
    }

    public function isPut()
    {
        return $this->server['REQUEST_METHOD'] === 'PUT';
    }

    public function isDelete()
    {
        return $this->server['REQUEST_METHOD'] === 'DELETE';
    }

    public function isPatch()
    {
        return $this->server['REQUEST_METHOD'] === 'PATCH';
    }

    public function getMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getUri()
    {
        return $this->server['REQUEST_URI'];
    }

    public function getBaseUrl()
    {
        return $this->server['SCRIPT_NAME'];
    }

    public function getPathInfo()
    {
        return $this->server['PATH_INFO'];
    }

    public function getQueryString()
    {
        return $this->server['QUERY_STRING'];
    }

    public function getHost()
    {
        return $this->server['HTTP_HOST'];
    }

    public function getProtocol()
    {
        return $this->server['SERVER_PROTOCOL'];
    }

    public function getReferer()
    {
        return $this->server['HTTP_REFERER'];
    }

    public function getUserAgent()
    {
        return $this->server['HTTP_USER_AGENT'];
    }

    public function getIp()
    {
        return $this->server['REMOTE_ADDR'];
    }

    public function getLanguage()
    {
        return $this->server['HTTP_ACCEPT_LANGUAGE'];
    }

    public function getCharset()
    {
        return $this->server['HTTP_ACCEPT_CHARSET'];
    }

    public function getEncoding()
    {
        return $this->server['HTTP_ACCEPT_ENCODING'];
    }

    public function getAccept()
    {
        return $this->server['HTTP_ACCEPT'];
    }

    public function getContentType()
    {
        return $this->server['CONTENT_TYPE'];
    }

    public function getContentLength()
    {
        return $this->server['CONTENT_LENGTH'];
    }

    public function getRequestMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getScriptName()
    {
        return $this->server['SCRIPT_NAME'];
    }

    public function getScriptFilename()
    {
        return $this->server['SCRIPT_FILENAME'];
    }

    public function getServerName()
    {
        return $this->server['SERVER_NAME'];
    }

    public function getServerPort()
    {
        return $this->server['SERVER_PORT'];
    }

    public function getServerSoftware()
    {
        return $this->server['SERVER_SOFTWARE'];
    }

    public function getServerProtocol()
    {
        return $this->server['SERVER_PROTOCOL'];
    }

    public function getServerAdmin()
    {
        return $this->server['SERVER_ADMIN'];
    }

    public function getDocumentRoot()
    {
        return $this->server['DOCUMENT_ROOT'];
    }

    public function getRemoteHost()
    {
        return $this->server['REMOTE_HOST'];
    }

    public function getRemoteAddr()
    {
        return $this->server['REMOTE_ADDR'];
    }

    public function getRemotePort()
    {
        return $this->server['REMOTE_PORT'];
    }

    public function getRemoteUser()
    {
        return $this->server['REMOTE_USER'];
    }

    public function getAuthType()
    {
        return $this->server['AUTH_TYPE'];
    }

    public function getHttpAccept()
    {
        return $this->server['HTTP_ACCEPT'];
    }

    public function getHttpAcceptCharset()
    {
        return $this->server['HTTP_ACCEPT_CHARSET'];
    }

    public function getHttpAcceptEncoding()
    {
        return $this->server['HTTP_ACCEPT_ENCODING'];
    }

    public function getHttpAcceptLanguage()
    {
        return $this->server['HTTP_ACCEPT_LANGUAGE'];
    }

    public function getHttpAuthorization()
    {
        return $this->server['HTTP_AUTHORIZATION'];
    }

    public function getHttpCacheControl()
    {
        return $this->server['HTTP_CACHE_CONTROL'];
    }

    public function getHttpConnection()
    {
        return $this->server['HTTP_CONNECTION'];
    }

    public function getHttpCookie()
    {
        return $this->server['HTTP_COOKIE'];
    }

    public function getHttpContentLength()
    {
        return $this->server['HTTP_CONTENT_LENGTH'];
    }

    public function getHttpContentType()
    {
        return $this->server['HTTP_CONTENT_TYPE'];
    }

    public function getHttpDate()
    {
        return $this->server['HTTP_DATE'];
    }

    public function getHttpExpect()
    {
        return $this->server['HTTP_EXPECT'];
    }

    public function getHttpFrom()
    {
        return $this->server['HTTP_FROM'];
    }

    public function getHttpHost()
    {
        return $this->server['HTTP_HOST'];
    }

    public function getHttpIfModifiedSince()
    {
        return $this->server['HTTP_IF_MODIFIED_SINCE'];
    }

    public function getHttpIfNoneMatch()
    {
        return $this->server['HTTP_IF_NONE_MATCH'];
    }

    public function getHttpPragma()
    {
        return $this->server['HTTP_PRAGMA'];
    }

    public function getHttpReferer()
    {
        return $this->server['HTTP_REFERER'];
    }

    public function getHttpUserAgent()
    {
        return $this->server['HTTP_USER_AGENT'];
    }

    public function getHttpXForwardedFor()
    {
        return $this->server['HTTP_X_FORWARDED_FOR'];
    }

    public function getHttpXForwardedHost()
    {
        return $this->server['HTTP_X_FORWARDED_HOST'];
    }

    public function getHttpXForwardedProto()
    {
        return $this->server['HTTP_X_FORWARDED_PROTO'];
    }

    public function getHttpXRequestedWith()
    {
        return $this->server['HTTP_X_REQUESTED_WITH'];
    }

    public function getHttpXRealIp()
    {
        return $this->server['HTTP_X_REAL_IP'];
    }

    public function getHttpXRewriteUrl()
    {
        return $this->server['HTTP_X_REWRITE_URL'];
    }
}
