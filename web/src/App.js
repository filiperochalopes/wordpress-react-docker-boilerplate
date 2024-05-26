import { theme, GlobalStyles } from "./styles";

import AppContext from "services/context";

import React, { useState } from "react";
import { BrowserRouter as Router } from "react-router-dom";
import Routes from "services/Routes";
import { ThemeProvider } from "styled-components";

function App() {
  const [user, setUser] = useState(false); // true or false

  return (
    <AppContext.Provider value={{ user, setUser }}>
      <ThemeProvider theme={theme}>
        <GlobalStyles />
        <Router>
          <Routes />
        </Router>
      </ThemeProvider>
    </AppContext.Provider>
  );
}

export default App;
