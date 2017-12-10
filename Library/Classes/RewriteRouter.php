<?php

class RewriteRouter extends Router
{
    public function route(Request $request)
    {

        //поменял всю регулярку для парсинга роута
        $re = '%
    # Parse controller, action, params and type from route.
    ^                    # Anchor to start of string.
    /                    # $controller prefix (required).
    (?P<controller>      # $controller (required).
      [^/\\\\.]+         # Value = one or more non-/\..
    )                    # $controller (required).
    (?:                  # Action is optional.
      /                  # $action prefix.
      (?P<action>        # $action.
        [^/\\\\.]+       # Value = one or more non-/\..
      )                  # $action.
    )?                 # Action is optional.
    (?:                  # Parameters are optional.
      (?P<params>        # $params.
        (?:              # One or more parameters
          /              # Params separated by a /.
          [^/\\\\.]+     # Value = one or more non-/\..
        )+               # One or more parameters
      )                  # $params.
    )?
       /?                
    $                    # Anchor to end of string.
    %x';

        if (!$request instanceof HttpRequest)
            throw new Exception ('Invalid request class');

        //if (preg_match('~/(?P<controller>[^/]+)(?:/(?P<action>[^/]+)?)~', $request->getBaseUrl(), $matches)) {
        if (preg_match($re, $request->getBaseUrl(), $matches)) {
            $request->setControllerName($matches['controller']);

            if (isset($matches['params']))
                $request->setParams(explode('/',$matches['params']));
            if (isset($matches['action']))
                $request->setActionName($matches['action']);
            else
                $request->setActionName('Index');
        } else {
            $request->setControllerName('Index');
            $request->setActionName('Index');
        }

    }
}