<pre><?php
unset($dataForView);
unset($viewFile);
unset($debugToolbarPanels);
unset($debugToolbarJavascript);
unset($debugToolbarCss);

echo json_encode(get_defined_vars());
