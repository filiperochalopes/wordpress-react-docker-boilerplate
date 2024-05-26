import { createGlobalStyle } from "styled-components";

export const theme = {
  white: "#fff",
  black: "#000",
};

export const GlobalStyles = createGlobalStyle`
  *{
    margin: 0;
    padding: 0;
    font-family: 'Raleway', sans-serif;
  }

  h1, h2{
    font-family: 'Arvo', serif;
  }

  html, body, #root{
    height: 100%;
    background: ${(props) => props.theme.white};
    text-align: center;
  }

  h1{
    color: ${(props) => props.theme.black};
  }

  .flex {
    display: flex;
    &.space-between { justify-content: space-between }
    &.align-end { align-items: flex-end }
    &.justify-end { justify-content: flex-end }
    &.center { align-items: center }
  }
`;
