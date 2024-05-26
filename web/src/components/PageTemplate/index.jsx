import { Container } from "./styles";

import Header from "components/Header";
import PropTypes from "prop-types";
import React from "react";

const PageTemplate = ({ children }) => (
  <Container>
    <Header />
    {children}
  </Container>
);

PageTemplate.propTypes = {
  children: PropTypes.elementType.isRequired,
};

export default PageTemplate;
