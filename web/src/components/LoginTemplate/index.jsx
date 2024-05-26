import { Container } from "./styles";

import PropTypes from "prop-types";
import React from "react";

const LoginTemplate = ({ children }) => <Container>{children}</Container>;

LoginTemplate.propTypes = {
  children: PropTypes.elementType.isRequired,
};

export default LoginTemplate;
