//import file from font awesome manually
import { library, dom } from "@fortawesome/fontawesome-svg-core";
import { faCaretUp } from "@fortawesome/free-solid-svg-icons";
import { faCaretDown } from "@fortawesome/free-solid-svg-icons";
import { faStar } from "@fortawesome/free-solid-svg-icons";
import { faCheck } from "@fortawesome/free-solid-svg-icons";

// //call the custom fontawesome
library.add([faCaretDown, faCaretUp, faCheck, faStar]);

dom.watch();